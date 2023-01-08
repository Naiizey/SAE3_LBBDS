#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <fcntl.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>
#include "file.h"


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
    new->etat=NULL;
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
        }else if(strcmp(json->string, "etat")==0 && json->type==cJSON_String){
            if( json->type==cJSON_String){
                new->etat=json->valuestring;
            /*
            if (!verifEtat(json->string)){
                return -1;
            }
            */
        }else{
            return NULL;
        }
        
       
    }
    
    json=json->next;
}


if(new->etat!=NULL && new->identifiant>=0)
    return new;
else
    return NULL;
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


int parcoursLivraisons(cJSON *json, Element **liste){
    #if TEST == true
    printf("Parcours...\n");
    #endif
    Element * result;
    if(json->type == cJSON_Object)
    {
        if (json->child==NULL || json->child->string==NULL) return -1;
        if(strcmp(json->child->string,"livraison")==0){
            result=collectLivraison(json->child->child);
  

            
        }
        else{
             printf("Erreur: type non accepté\n");
            return -1;
        }
       
    }
    else if(json->type == cJSON_Array)
    {
        //if (verif(json,context->string) < 0) return -1;
        if(strcmp(json->string,"livraisons")==0){
                json=json->child;
                while(json!=NULL){
                    result=collectLivraison(json);
                    if(result==NULL) return -1;
                    json=json->next;
                }

        }
    }
    else
    {
        printf("Erreur: type non accepté\n");
        return -1;
    }

    
    if(json->next!=NULL){
        return parcoursLivraisons(json->next,liste);
    }else if(result!=NULL){
        *liste=result;
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
        
        Element * liste = (Element *)malloc(sizeof(Element));

        
        int retour = parcoursLivraisons(json,&liste);
        printf("Result : %d\n {%ld,%s}\n", retour,liste->timestamp,liste->etat);
       

    }

   
    
    return 0;
}
