#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <fcntl.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>
#include "file.h"


#include <unistd.h>


#define MAX_PA 30
#define TEST true
const int MAX_ETAPE=6;





typedef struct {
    char * id;
    char * pass;
} user;

bool verifEtat(char * etat);

/**
 * @brief A partir d'un objet json, on collecte les information correspondante à une livraison
 * 
 * @param json un Objet json
 * @return Element* 
 */
Element * collectLivraison(cJSON * json){
    Element * new =(Element *)malloc(sizeof(Element));
    new->identifiant=-1;
    new->timestamp=0;
    new->joursRetard=0;
    strcpy(new->etat,"\0");
    #if TEST == true
    printf("Commence... \n");
    #endif
    
    while(json!=NULL && (json->type==cJSON_Number || json->type==cJSON_String)){
        #if TEST == true
        printf("Collecte !\n");;
        #endif
        
        if(json->type==cJSON_Number){
            if(strcmp(json->string,"identifiant")==0 && json->type==cJSON_Number){
                new->identifiant=json->valueint;
            }
            else if(strcmp(json->string, "time")==0){
                new->timestamp=time(NULL);
            }else if(strcmp(json->string,"retard")==0 ){
                new->joursRetard=json->valueint;
            }
        }else if(strcmp(json->string, "etat\0")==0 && json->type==cJSON_String){
            

            strcpy(new->etat,json->valuestring);
            
            
            /*if (!verifEtat(json->string)){
                return -1;
            }*/

            
        }else{
            #if TEST == true
            printf("Refus format...\n");
            #endif
            return NULL;
        }
        
       json=json->next;
    }
    
    


    #if TEST == true
    printf("Fin collecte !\n");
    #endif
    if(strcmp(new->etat,"\0")!=0 && new->identifiant>=0)
        return new;
    else
    {
        #if TEST == true
        printf("Refus résultat...{%d}\n",new->identifiant);
        #endif
        return NULL;
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
 * @brief Parcour une ou des livraisons et remplie la file en conséquence, on va aussi vérifier que le format est standard au Protocole
 * 
 * @param json le root du json
 * @param liste la file
 * @return int 
 */
int parcoursLivraisons(cJSON *json, File *liste){
    #if TEST == true
    printf("Test type...\n");
    #endif

    Element * result;
    if (json->child==NULL || json->child->string==NULL) return -1;
    if(json->child->type == cJSON_Object)
    {
        #if TEST == true
        printf("Objets...\n");
        #endif
        
        if(strcmp(json->child->string,"livraison")==0){
            result=collectLivraison(json->child->child);
  

            
        }
        else{
             printf("Erreur: type non accepté\n");
            return -1;
        }
       
    }
    else if(json->child->type == cJSON_Array)
    {
        #if TEST == true
        printf("Array...\n");
        #endif
        //if (verif(json,context->string) < 0) return -1;
        if(strcmp(json->child->string,"livraisons")==0){
                json=json->child->child;
                while(json!=NULL){
                    result=collectLivraison(json->child);
                    #if TEST == true
                        printf("Fin :\n");
                     #endif
                    if(result==NULL){
                        return -1;
                    }else{
                        enfiler(liste,result);

                    }
 
                    json=json->next;
                }

        }
    }
    else
    {
        printf("Erreur: type non accepté\n");
        return -1;
    }

    #if TEST == true
        printf("Fin parcours...\n");
    #endif
    if(json != NULL && json->next!=NULL){

        return parcoursLivraisons(json->next,liste);
    }else if(result!=NULL){
        
        return 0;
    }else
        return -1;
}

/*
int parcoursAuth(cJSON *json, user *theUser){
    printf("Parcours...\n");
    user * result;
    if(json->type == cJSON_Object)
    {
        if (strcmp(json->child->string,"auth")==0){
            *result=collectInfoUser(json->child);
        }
        else{
             printf("Erreur: type non accepté\n");
            return -1;
        }
       
    }
    
    if(json->next!=NULL){
        return parcoursAuth(json->next,theUser);
    }else if(result!=NULL){
        *theUser=*result;
        return 0;
    }else
        return -1;
}
*/
const char * traitementEtat(char * etat, time_t delta){
    return "destinataire";
}  

cJSON * createLivraison(Element e){
    time_t depuis = time(NULL) - e.timestamp;
    cJSON * livraison = cJSON_CreateObject();
    cJSON_AddItemToObject(livraison,"identfiant",cJSON_CreateNumber(e.identifiant));
    cJSON_AddItemToObject(livraison,"time",cJSON_CreateNumber(depuis));
    cJSON_AddItemToObject(livraison,"etat",cJSON_CreateString(traitementEtat(e.etat,depuis)));
    return livraison;
    
}

cJSON * envoiLivraison(File *file, char * filter){
    cJSON * retour = cJSON_CreateObject();
    cJSON * array = cJSON_CreateArray();
    Element * current = *file;
    while(current!=NULL){
        #if TEST == true
        printf("Item.\n");
        #endif
        cJSON_AddItemToArray(array,createLivraison(*current));
        current=defiler(file);
    }
    cJSON_AddItemToObject(retour,"livraisons",array);
    return retour;

}
int main(int argc, char const *argv[])
{
    char buff[1024];
 
    int fd = open("test.json", O_RDONLY);
    #if TEST == true
    printf("Ouverture...\n");
    #endif
    
    if (fd<0) return -1;
    #if TEST == true
    printf("Lecture...\n");
    #endif
    
  
    if (read(fd,buff,1024)<0) return -1;
    
    #if TEST == true
    printf("Parsing...\n");
    #endif
    cJSON *json = cJSON_Parse(buff);
   
    if(json == NULL) 
    {
     
        printf("\n");
        return -1;
    }
    else{
        #if TEST == true
        printf(cJSON_Print(json));
        #endif
        
        File liste;
        initFile(&liste);

        
        int retour = parcoursLivraisons(json,&liste);
        if(retour != -1){
            sleep(6);
            cJSON * oui = envoiLivraison(&liste,"");
            printf(cJSON_Print(oui));
            printf("\n");

        }
       
       

    }

   
    
    return 0;
}
