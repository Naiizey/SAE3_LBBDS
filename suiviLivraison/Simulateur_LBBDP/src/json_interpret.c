
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>


#include "fifo.h"
#include "user.h"
#include"json.h"
#define TEST true




/**
 * @brief Collectes les infomations permettant l'authentification
 * 
 * @param json 
 * @param new 
 * @return user* 
 */
user * collectInfoUser(cJSON * json,user * new){
    
    new->id=(char *)malloc(255 * sizeof(char));
    new->pass=(char *)malloc(255 * sizeof(char));
    strcpy(new->id,"\0");
    strcpy(new->pass,"\0");
  
    #if TEST == true
        printf("Commence... \n");
        printf("%s\n",cJSON_Print(json));
    #endif
    
    //Parcours du JSON
    while(json!=NULL && json->type==cJSON_String){
        #if TEST == true
        printf("Collecte !\n");;
        #endif
        //Récupération des champs nécessaires
        if(json->type==cJSON_String){
            if(strcmp(json->string,"id")==0){
                strcpy(new->id,json->valuestring);
                printf("là id: %s\n",new->id);
            }
            else if(strcmp(json->string, "pass")==0){
                strcpy(new->pass,json->valuestring);
                printf("là id: %s\n",new->pass);
            }else{
                printf("champs de \"auth\" inconnu\n");
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
        printf("Refus résultat...{%s,%s}\n",new->id,new->pass);
        #endif
        return NULL;
    }
        
}

/**
 * @brief A partir d'un objet json, on collecte les information correspondante à une livraison
 * 
 * @param json un Objet json
 * @return Element* 
 */
Livraison * collectLivraison(cJSON * json){
    Livraison *new=(Livraison *)(malloc(sizeof(Livraison)));
    *new=createLivraison("\0",0,"En charge");

    #if TEST == true
    printf("Commence... \n");
    #endif
    
    while(json!=NULL && (json->type==cJSON_Number || json->type==cJSON_String)){
        #if TEST == true
        printf("Collecte champs ! ");;
        #endif
        
        if(json->type==cJSON_Number){
            
            if(strcmp(json->string, "time")==0){
                new->timestamp=time(NULL);
            }
        }else if(json->type==cJSON_String){
            if(strcmp(json->string,"identifiant")==0){
                strcpy(new->identifiant,json->valuestring);
                printf("Id!");
            }else if(strcmp(json->string, "etat\0")==0){
                int result=verifEtat(json->valuestring);
                if (result!=(ERR_ETAT)){
                    strcpy(new->etat,json->valuestring);
                    
                }else{
                    #if TEST == true
                    printf("Erreur etat !\n");;
                    #endif
                    return NULL;
                }

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
    printf("\nFin collecte !\n");
    #endif
    if(strcmp(new->etat,"\0")!=0 && strcmp(new->identifiant,"\0")!=0)
        return new;
    else
    {
        #if TEST == true
        printf("\nRefus résultat...{%s}\n",new->identifiant);
        #endif
        return NULL;
    }
        
}



/**
 * @brief Parcours une ou des livraisons et remplie la file en conséquence, on va aussi vérifier que le format est standard au protocole LBBDP. On peut aussi collecter des identifiants
 * 
 * @param json 
 * @param liste 
 * @param client 
 * @param ind 
 * @param max 
 * @param chercheLivr 1: chercher livraison, 0: ne pas les chercher, -1: envoyer erreur si champs "livraison" ou "livraisons" trouvé
 * @param chercheAuth  1: chercher identifiants, 0: ne pas les chercher, -1: envoyer erreur si champs "auth" trouvé
 * @return int 
 */
int parcours(cJSON *json, File *liste, user * client,int chercheLivr, int chercheAuth){
   
    
    if (json==NULL || json->string==NULL) {
        printf("Erreur json null ou root séléctionné\n");
        return -41;
    }
        
    
    #if TEST == true
    printf("Test type...\n");
    #endif

    Livraison * result;
    
    if(json->type == cJSON_Object)
    {
        #if TEST == true
        printf("Objets...\n");
        #endif
        
        if(strcmp(json->string,"livraison")==0){

            if(chercheLivr){
                #if TEST == true
                printf("Livraison...\n");
                #endif
                result=collectLivraison(json->child);   
                if(result==NULL){
                            return -1;
                    }else{
                        ajoutFile(liste,*result);

                    }
            }else if(chercheLivr>0){
                printf("Erreur: champs \"livraison\" non accepté ici\n");
                return -1;
            }

        }
        else if(strcmp(json->string,"auth")==0 && json->child != NULL){

            if(chercheAuth){
                 #if TEST == true
                printf("User...\n");
                #endif
                
                collectInfoUser(json->child,client);
                
                if(client==NULL){
                    return -1;
                }  
            }else if(chercheAuth>0){
                printf("Erreur: champs \"auth\" non accepté ici\n");
                return -1;
            }
        }
        else{
            
            printf("Erreur: champs non accepté\n");
            return -1;
        }
       
    }
    else if(json->type == cJSON_Array)
    {
        if(chercheLivr){
            #if TEST == true
            printf("Array...\n");
            #endif
            //if (verif(json,context->string) < 0) return -1;
            if(strcmp(json->string,"livraisons")==0){
                    cJSON * children;
                    children=json->child;
                    #if TEST == true
                        printf("LivraisonS...\n");
                    #endif
                    while(children!=NULL){
                        
                        result=collectLivraison(children->child);
                        #if TEST == true
                            printf("Fin.\n");
                        #endif
                        if(result==NULL){
                            return -1;
                        }else{
                            ajoutFile(liste,*result);

                        }
    
                        children=children->next;
                    }

            }
        }else if(chercheLivr>0){
            printf("Erreur: champs \"livraisons\" non accepté ici\n");
            return -1;
        }
        
    }
    else
    {
        printf("Erreur: type non accepté, %d\n",json->type);
        return -1;
    }

    #if TEST == true
        printf("Fin parcours...\n");
    #endif
    if(json != NULL && json->next!=NULL){

        return parcours(json->next,liste,client, chercheLivr, chercheAuth);
    }else
        return 0;
}

/**
 * @brief parcours() tout en bannissant les champs "livraison" et "livraisons"
 * @see parcours()
 * 
 * @param json 
 * @param liste 
 * @param client 
 * @param ind 
 * @param max 
 * @return int 
 */
int parcoursPourAuth(cJSON *json, user * client){
    return parcours(json,NULL,client, 0, 1);
}

/**
 * @brief parcours() tout en ignorant le champs "auth"
 * @see parcours()
 * 
 * @param json 
 * @param liste 
 * @param client 
 * @param ind 
 * @param max 
 * @return int 
 */
int parcoursPourLivraison(cJSON *json, File *liste){
    return parcours(json,liste,NULL, 1, 0);
}






/**
 * @brief Sérialisation en JSON d'une commande.
 * 
 * @param e 
 * @return cJSON* 
 */
cJSON * prepLivraison(Livraison e){
    

    cJSON * livraison = cJSON_CreateObject();
    cJSON_AddItemToObject(livraison,"identifiant",cJSON_CreateString(e.identifiant));
    cJSON_AddItemToObject(livraison,"time",cJSON_CreateNumber(e.jours));
    cJSON_AddItemToObject(livraison,"etat",cJSON_CreateString(e.etat));
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
    Livraison * current = retraitFile(file);
    while(current!=NULL){
        #if TEST == true
        printf("Identifiant: %s\n", current->identifiant);

        printf("Item.\n");
        #endif
        cJSON_AddItemToArray(array,prepLivraison(*current));
        current=retraitFile(file);
    }
    cJSON_AddItemToObject(retour,"livraisons",array);
    return retour;

}


