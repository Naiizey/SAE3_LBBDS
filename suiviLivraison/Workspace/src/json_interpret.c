#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>


#include "file.h"
#include "user.h"
#include"json.h"
#define TEST true


const int TEMPS_MAX_REGIONAL=3;
const int TEMPS_LOCAL=1;
#define MAX_ETAPE 4
const int ETAT_FINAL=-1;
const int ERR_ETAT=-2;

const int TIME_DAY_SEC=2;



user * collectInfoUser(cJSON * json){
    user * new =(user *)malloc(sizeof(user));
    new->id="";
   
    strcpy(new->id,"\0");
    strcpy(new->pass,"\0");
    #if TEST == true
    printf("Commence... \n");
    #endif
    
    while(json!=NULL && json->type==cJSON_String){
        #if TEST == true
        printf("Collecte !\n");;
        #endif
        
        if(json->type==cJSON_String){
            if(strcmp(json->string,"identifiant")==0 && json->type==cJSON_Number){
                strcpy(new->id,json->valuestring);
            }
            else if(strcmp(json->string, "pass")==0){
                strcpy(new->id,json->valuestring);
            }
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
    if(strcmp(new->id,"\0")!=0 && strcmp(new->pass,"\0")!=0)
        return new;
    else
    {
        #if TEST == true
        printf("Refus résultat...{%s}\n",new->id);
        #endif
        return NULL;
    }
        
}

typedef struct {
    char * nom;
    int apresXjour;
} etatLivraison;

typedef etatLivraison etats[MAX_ETAPE];
const etats quelEtape = {
    {"En charge",0},
    {"regional",TEMPS_MAX_REGIONAL},
    {"local",TEMPS_MAX_REGIONAL+TEMPS_LOCAL},
    {"destinataire",ETAT_FINAL}

};

/**
 * @brief Retourne le nombre de jour avant la fin d'un état, si celui-ci existe.
 * 
 * @param etat 
 * 
 * 
 * @return true 
 * @return false 
 */
int verifEtat(char * etat){
    bool trouve=false;
    int i=0;
    while(i<MAX_ETAPE && !trouve){
        trouve=(strcmp(quelEtape[i].nom,etat)==0);
        i++;
    }
    if(trouve){
        i--;
        return quelEtape[i].apresXjour;
    }
    else{
        return ERR_ETAT;
    }
}

/**
 * @brief Permet de retourner l'état en fonction de l'état d'entré du simulateur et de temps passé.
 * 
 * @param etat état à l'entrée du simulateur 
 * @param jour état passé dans le simulateur
 * @return const char* 
 */
const char * traitementEtat(char * etat, int jour){
    bool trouve=false;
    int i=0;
    while( i<MAX_ETAPE && !trouve){
        trouve=quelEtape[i].apresXjour==ETAT_FINAL || quelEtape[i].apresXjour >= jour;
        i++;
    }
    if(trouve)
    {
        i--;
        return quelEtape[i].nom;
    }
    else
        return NULL;
    
}  

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
    strcpy(new->etat,"En charge");
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
            int result=verifEtat(json->valuestring);
            if (result!=ERR_ETAT){
                strcpy(new->etat,json->valuestring);
                
            }else{
                #if TEST == true
                printf("Erreur etat !\n");;
                #endif
                return NULL;
            }

            
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



/**
 * @brief Parcour une ou des livraisons et remplie la file en conséquence, on va aussi vérifier que le format est standard au Protocole
 * 
 * @param json le root du json
 * @param liste la file
 * @return int 
 */
int parcours(cJSON *json, File *liste, user * client){
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
            if(result==NULL){
                        return -1;
                }else{
                    enfiler(liste,result);

                }
        }
        else if(strcmp(json->child->string,"auth")==0){
            client=collectInfoUser(json->child->child);
            if(client==NULL){
                return -1;
            }  
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

        return parcours(json->next,liste,client);
    }else if(result!=NULL){
        
        return 0;
    }else
        return -1;
}





/**
 * @brief Retourne en seconde la différence entre deux temps
 * 
 * @param avant 
 * @param maintenant 
 * @return int 
 */
int convertEnJour(time_t avant, time_t maintenant){
    time_t diff = difftime(maintenant, avant);
    struct tm * diffInfos = localtime(&diff);
    if(diffInfos!=NULL){
        return diffInfos->tm_sec/TIME_DAY_SEC;
    }else{
        return -1;
    }
}

/**
 * @brief Sérialisation en JSON d'une commande.
 * 
 * @param e 
 * @return cJSON* 
 */
cJSON * createLivraison(Element e){
    
    int depuis = convertEnJour(e.timestamp, time(NULL));
    cJSON * livraison = cJSON_CreateObject();
    cJSON_AddItemToObject(livraison,"identfiant",cJSON_CreateNumber(e.identifiant));
    cJSON_AddItemToObject(livraison,"time",cJSON_CreateNumber(depuis));
    cJSON_AddItemToObject(livraison,"etat",cJSON_CreateString(traitementEtat(e.etat,depuis)));
    return livraison;
    
}
/**
 * @brief Construit un JSON qui répertorie plusieurs commandes
 * 
 * @param file 
 * @param filter 
 * @return cJSON* 
 */
cJSON * envoiLivraison(File *file, char * filter){
    cJSON * retour = cJSON_CreateObject();
    cJSON * array = cJSON_CreateArray();
    Element * current = defiler(file);
    while(current!=NULL){
        #if TEST == true
        printf("Identifiant: %d\n", current->identifiant);

        printf("Item.\n");
        #endif
        cJSON_AddItemToArray(array,createLivraison(*current));
        current=defiler(file);
    }
    cJSON_AddItemToObject(retour,"livraisons",array);
    return retour;

}


