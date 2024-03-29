#include <stdio.h>
#include <stdlib.h>
#include <openssl/md5.h>
#include <arpa/inet.h>
#include <string.h>
#include <stdbool.h>
#include "user.h"


const int EXTENSION = 20;


void * init_array_session(int max_array){
    return calloc(max_array,sizeof(user));
}



/**
 * @brief Récupère l'ip d'un sockaddr
 * @aide : https://beej.us/guide/bgnet/html/#structs
 * @param adr 
 * @return char* 
 */
char * getIp(struct sockaddr adr){
    void *tmp;
    char * retour;
    int size;
    if(adr.sa_family==AF_INET){
        size=INET_ADDRSTRLEN;
        retour=(char *)malloc(size * sizeof(char));
        struct sockaddr_in * ipv4 = (struct sockaddr_in *)adr.sa_data;
        tmp = &(ipv4->sin_addr);
    }else if(adr.sa_family==AF_INET6){
        size=INET6_ADDRSTRLEN;
        retour=(char *)malloc(size * sizeof(char));
        struct sockaddr_in6 * ipv6 = (struct sockaddr_in6 *)adr.sa_data;
        tmp = &(ipv6->sin6_addr);
    }else{
        printf("Gros problème...\n");
        return NULL;
    }
    inet_ntop(adr.sa_family, tmp, retour, size);
    return retour;

}

/**
 * @brief Trouve si le client est déjà connecté en utilisant son adresse IP
 * 
 * @param arr 
 * @param ind 
 * @param adr 
 * @return user* 
 */
user * IPdejaConnecte(arrayUser arr,int ind,struct sockaddr adr){
    char * clientIp=getIp(adr);
    int trouve=-1;
    for(int i=0;i<ind && trouve<0;i++){
        trouve=(strcmp(clientIp,getIp(arr[i].addr))==0)?i:-1;
    }
    if(trouve>=0){
        return &(arr[trouve]);
    }else{
        return NULL;
    }
}
/**
 * @brief Ajoute une nouvelle session dans l'array, si celui-ci est trop petit il sera agrandit.
 * 
 * @param arr 
 * @param ind 
 * @param new 
 * @return char* 
 */
char * addSession(arrayUser arr,int * ind,user new, int * max_array){
    if(arr != NULL){
        printf("Poursuite connection...1\n");
        bool trouve=false;
        for(int i=0;i<(*ind) && !trouve;i++){
            trouve=(arr[*ind].id==new.id);
        }
        printf("Poursuite connection...2, %d, %d, %d\n", (*ind), trouve, *max_array);
        if(trouve){
            return NULL;
        }else {
            printf("Poursuite connection...3\n");
            if((*ind)>=(*max_array)){
                (*max_array)=(*max_array)+EXTENSION;
                printf("Poursuite connection...33\n");
                arr =(user *)realloc(arr, (*max_array) * sizeof(user));
                printf("Poursuite connection...37\n");

            }
            printf("Poursuite connection...4\n");
            
            arr[(*ind)]=new;
            (*ind)=(*ind)+1;
            return new.id;
        }
         printf("Poursuite connection...5\n");
        
    }else
        return NULL;
    
}

/**
 * @brief Nettoie les sessions trop vielles.
 * 
 * @param arr 
 * @param ind 
 */
void nettoyerSessions(arrayUser arr, int * ind);

//TODO: Passage en option du path vers le fichier, du mot de passe et de l'identifiant

// Taille maximale du buffer de read ( 1000 caractères )
int size = 1001;

// Hashage en MD5
void md5_hasher(char *string, char *hash)
{
    char unsigned md5[MD5_DIGEST_LENGTH] = {0};

    //Fonction MD5 qui permet de préparer le hashage
    MD5((const unsigned char *)string, strlen(string), md5);

    //Boucle qui permet de hasher en MD5
    for(int i=0; i < MD5_DIGEST_LENGTH; i++){
        //Sprintf écrit dans une variable
        sprintf(hash + 2*i, "%02x", md5[i]);
    }
}

//Vérification du mot de passe contenu dans un fichier
int verify_password(char *path, char *id, char *hashedPass){
    printf("Vérification mot de passe..\n");
    FILE *fp;
    int retour;
    //Création du buffer qui recevra les caractères lus
    char buffer[size];

    //Ouverture du fichier en read
    fp=fopen(path, "r");
     
    if(fp != NULL){
        //Lecture du fichier avec les caractères mis dans le buffer
        
        if(fread(buffer, size, 1, fp) >=0){
            //Si le buffer contient le mot de pass hashé ainsi que l'id, return vrai
            //TODO: strstr pas adapté
            
            if(strstr(buffer, hashedPass) != NULL && strstr(buffer, id) != NULL){
                retour= 0;
            }else{
                retour= -22;
            }
        }else{
            printf("Problème lecture fichier\n");
            retour= -50;
        }   
        fclose(fp);
    }else{
        printf("Problème ouverture fichier\n");
        retour= -50;
    }
    
    return retour;

   

    
}
/**
 * @brief Connecte le client en ajoutant sa session à l'array
 * 
 * @param client 
 * @param addr 
 * @return true 
 * @return false 
 */
int connection(user * client, struct sockaddr addr, arrayUser arr, int *ind,int *max, char * mdpFile){
    
    printf("%s %s\n",client->id, client->pass);
    int retour=(client->id == NULL || client->pass == NULL)?-21:0;
    printf("%d",retour);
    printf("Connection en cours...\n");
    if(retour==0){
        retour=verify_password(mdpFile,client->id,client->pass);
        if(retour==0){
            client->session=time(NULL);
            client->addr=addr;
            printf("Connection en cours...7\n");
            retour = (addSession(arr,ind,*client,max)!=NULL)?0:-50;
            printf("Connection en cours...8\n");
        }
    }
     
    
    return retour;
}


