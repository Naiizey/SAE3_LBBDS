#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <fcntl.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>


#define MAX_PA 30

const int MAX_ETAPE=6;



//!! A ENLEVER PLUS TARD : 
typedef struct fifo {
    int identifiant;
    int nombre;
    time_t timestamp;
    char * etat; 
    int joursRetard;
    struct fifo *next;
} fifo;



typedef struct {
    char * id;
    char * pass;
} user;

bool verifEtat(char * etat);


fifo * collectLivraison(cJSON * json){
    fifo * new =(fifo *)malloc(sizeof(fifo));
    new->joursRetard=0;
    while(json!=NULL && (json->type==cJSON_Number || json->type==cJSON_String)){
        if(json->type==cJSON_Number){
            if(strcmp(json->string,"identifiant")==0 && json->type==cJSON_Number){
                new->identifiant=json->valueint;
            }
            else if(strcmp(json->string,"nombre")==0 ){
                new->nombre=json->valueint;
            }else if(strcmp(json->string, "time")==0){
                new->timestamp=time(NULL);
            }else if(strcmp(json->string,"retard")==0 ){
                new->joursRetard=json->valueint;
            }
        }else if(strcmp(json->string, "etat")==0 && json->type==cJSON_String){
            if( json->type==cJSON_String){
                new->etat=json->valuestring;
            /*
            if (!verifEtat(json->string)){
                return -1;
            }
            */
        }
        
        json=json->next;
    }
}
}
user collectInfoUser(cJSON * json);

/*
typedef struct cJSON
{
    struct cJSON *next;
    struct cJSON *prev;
    struct cJSON *child;
    int type;
    char *valuestring;
    // writing to valueint is DEPRECATED, use cJSON_SetNumberValue instead 
    int valueint;
    double valuedouble;
    char *string;
} cJSON;

*/

/**
 * @brief Permet de répertorié les propriétées attendues dans le contenu des requêtes 
 * 
 */
typedef struct {
    char * context;
    int type;
    char * nom;

} proprieteAttendu;
typedef proprieteAttendu pA_tab[MAX_PA];

proprieteAttendu **p_att=NULL;
int *p_a_offset=0;

/**
 * @brief Ajout dans le tableau des propriétés attendues
 * 
 * @param tab 
 * @param offset 
 * @param type 
 * @param nom 
 * @param context 
 */
void ajoutpA(pA_tab tab, int * offset, int type, char * nom, char * context){
    proprieteAttendu pA;
    pA.context=context;
    pA.type=type;
    pA.nom=nom;
    tab[*offset]=pA;
    *offset=*offset+1;
}



/**
 * @brief Parcours le fichier de configuration permettant de connaitres les proprités attendues
 * @ref proprieteAttendu
 * 
 * @param json 
 * @param tab 
 * @param offset 
 * @param context 
 * @return int 
 */
int parcoursConfig(cJSON *json, pA_tab tab, int * offset, char * context){
    switch(json->type){
        case cJSON_Object:
            ajoutpA(tab,offset,cJSON_Object,json->string, context);
            if (json->child==NULL || parcoursConfig(json->child,tab,offset,json->string) < 0) return -1;
            
            break;
        case cJSON_Number:
            ajoutpA(tab, offset,cJSON_Number,json->string,context);
            break;
        case cJSON_String:
            ajoutpA(tab, offset, cJSON_String, json->string,context);
            break;
        default:
            printf("Erreur: type non accepté");
            return -1;
            break;

    }
    if(json->next!=NULL){
        return parcoursConfig(json->next,tab,offset,context);
    }else{
        return 0;
    }
    
}

/**
 * @brief Verifie qu'une propriété est bien attendue et qu'elle a bien les types et le context correspondant.
 * 
 * @param json 
 * @param tab 
 * @param offset 
 * @param context 
 * @return int 
 
int verif(cJSON *json, char * context){
    if(p_a_offset==0 || p_att==NULL) return -4;

    int retour = -1;
    for(int i = 0; i<p_a_offset && retour==-1; i++){
        if(strcmp(json->string,(*p_att)[i].nom)==0)
        {
            if (json->type!=(*p_att)[i].type){
                    printf("Erreur: pas le bon type");
                    retour=-2;
            }
            if (context!=(*p_att)[i].context){
                    printf("Erreur: pas le bon contexte");
                    retour=-3;
            }
            else {
                    retour=0;
            }
        
        }
                
    }
    return retour;
}
*/

/**
 * @brief  Répertorie les propriétés attendues, depuis un fichier de configuration
 * 
 * @return int 
 */
int buildconfig(){
    char buff[1024];
    int offset=0;
    pA_tab tab;
    int fd = open("config.json", O_RDONLY);
    printf("Ouverture...\n");
    if (fd<0) return -1;
    printf("Lecture...\n");
    if (read(fd,buff,1024)<0) return -1;
    
    printf("Parsing...\n");
    cJSON *json = cJSON_Parse(buff);
    printf(cJSON_Print(json));
    if(json == NULL) 
    {
     
        printf("\n");
        return -1;
    }

        
    printf("Parcours...%d\n",offset );
    int retour = parcoursConfig(json->child, tab, &offset,"");
    /*
    if (retour >= 0){
        for(int i=0; i<offset ;i++){
            printf("là %s\n",tab[i].nom);
        }
    }
    */

    const pA_tab const_tab = tab;
    const int const_off = offset;
    p_att=&const_tab;
    p_a_offset=&offset;

    return retour;
    
}


int parcours(cJSON *json, fifo **liste){
    if(json->type == cJSON_Object)
    {
        //if (verif(json,context->string) < 0) return -1;
        if(strcmp(json->string,"livraison")==0){
            collectLivraison(json->child);
        }
        else if (strcmp(json->string,"auth")==0){
            collectInfoUser(json->child);
        }
       
    }
    else if(json->type == cJSON_Array)
    {
        //if (verif(json,context->string) < 0) return -1;
        if(strcmp(json->string,"livraisons")==0){
                json=json->child;
                while(json!=NULL){
                    collectLivraison(json);
                    json=json->next;
                }

        }
    }
    else
    {
        printf("Erreur: type non accepté");
        return -1;
    }
    
    if(json->next!=NULL){
        return parcours(json->next,liste);
    }else{
        return 0;
    }
}

int main(int argc, char const *argv[])
{
    char buff[1024];
    int offset=0;
    pA_tab tab;
    int fd = open("config.json", O_RDONLY);
    printf("Ouverture...\n");
    if (fd<0) return -1;
    printf("Lecture...\n");
    if (read(fd,buff,1024)<0) return -1;
    
    printf("Parsing...\n");
    cJSON *json = cJSON_Parse(buff);
    printf(cJSON_Print(json));
    if(json == NULL) 
    {
     
        printf("\n");
        return -1;
    }

    fifo * liste = (fifo *)malloc(sizeof(fifo));

    printf("Parcours...%d\n",offset );
    int retour = parcours(json,NULL);
    
    
    return 0;
}
