#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <fcntl.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>


#define MAX_PA 30

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

typedef struct {
    char * context;
    int type;
    char * nom;

} proprieteAttendu;
typedef proprieteAttendu pA_tab[MAX_PA];


void ajoutpA(pA_tab tab, int * offset, int type, char * nom, char * context){
    proprieteAttendu pA;
    pA.context=context;
    pA.type=type;
    pA.nom=nom;
    tab[*offset]=pA;
    *offset=*offset+1;
}


int parcoursConfig(cJSON *json, pA_tab tab, int * offset, char * context){
    switch(json->type){
        case cJSON_Object:
            ajoutpA(tab,offset,cJSON_Object,json->string, context);
            if (json->child==NULL || parcours(json->child,tab,offset,json->string) < 0) return -1;
            
            break;
        case cJSON_Number:
            ajoutpA(tab,offset,cJSON_Number,json->string,context);
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
        return parcours(json->next,tab,offset,context);
    }else{
        return 0;
    }
    
}

int verif(cJSON *json, pA_tab tab, int offset, char * context){
    int retour = -1;
    for(int i = 0; i<offset && retour==-1; i++){
        if(strcmp(json->string,tab[i].nom)==0)
        {
            if (json->type!=tab[i].type){
                    printf("Erreur: pas le bon type");
                    retour=-2;
            }
            if (context!=tab[i].context){
                    printf("Erreur: pas le bon contexte");
            }
            else {
                    retour=0;
            }
        
        }
                
    }
    return retour;
}



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
    if (retour >= 0){
        for(int i=0; i<offset ;i++){
            printf("là %s\n",tab[i].nom);
        }
    }
    
    return retour;
    
}

int main(int argc, char const *argv[])
{
   
    printf("%d\n", buildconfig());
    
    return 0;
}
