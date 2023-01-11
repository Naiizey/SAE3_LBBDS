#include <stdio.h>
#include <stdlib.h>
#include <openssl/md5.h>
#include <arpa/inet.h>
#include <string.h>
#include <stdbool.h>
#include "user.h"

char * path = "/home/florian/giveSim";

const int EXTENSION = 20;

int max_array=20;
void * init_array_session(){
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
    if(adr.sa_family==AF_INET){
        retour=(char *)malloc(INET_ADDRSTRLEN * sizeof(char));
        struct sockaddr_in * ipv4 = (struct sockaddr_in *)adr.sa_data;
        tmp = &(ipv4->sin_addr);
    }else if(adr.sa_family==AF_INET6){
        retour=(char *)malloc(INET6_ADDRSTRLEN * sizeof(char));
        struct sockaddr_in6 * ipv6 = (struct sockaddr_in6 *)adr.sa_data;
        tmp = &(ipv6->sin6_addr);
    }else{
        printf("Gros problème...");
        return NULL;
    }
    inet_ntop(adr.sa_family, tmp, retour, sizeof (*retour));
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
char * addSession(arrayUser arr,int * ind,user new){
    if(arr != NULL){
        bool trouve=false;
        for(int i=0;i<(*ind) && !trouve;i++){
            trouve=(arr[*ind].id==new.id);
        }
        if(trouve){
            return NULL;
        }else {
            if((*ind)>=max_array){
                max_array=max_array+EXTENSION;
                arr = realloc(arr, max_array * sizeof(user));

            }
            arr[(*ind)]=new;
            (*ind)=(*ind)+1;
            return new.id;
        }
            
        
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
bool verify_password(char *path, char *id, char *hashedPass){
    FILE *fp;
    
    //Création du buffer qui recevra les caractères lus
    char buffer[size];

    //Ouverture du fichier en read
    fp = fopen(path, "r+");

    //Lecture du fichier avec les caractères mis dans le buffer
    fread(buffer, size, 1, fp);

    //Si le buffer contient le mot de pass hashé ainsi que l'id, return vrai
    if(strstr(buffer, hashedPass) != NULL && strstr(buffer, id) != NULL){
        return true;
    }

    return false;
}
/**
 * @brief Connecte le client en ajoutant sa session à l'array
 * 
 * @param client 
 * @param addr 
 * @return true 
 * @return false 
 */
bool connection(user * client, struct sockaddr addr, arrayUser arr, int *ind){
    if(verify_password(path,client->id,client->pass)){
        client->session=time(NULL);
        client->addr;
        return  addSession(arr,ind,*client)!=NULL;
    }else{
        return false;
    }
}

int main()
{

    char password[255] = "mdAdfbnrRtps";
    char id[55] = "153";

    char md5_hash[2*MD5_DIGEST_LENGTH+1] = "";

    printf("%s\n", path);

    md5_hasher(password, md5_hash);
    printf("%s\n", md5_hash);

    if(verify_password(path, id, md5_hash)){
        printf("ID et Password trouvés\n");
    }


    return 0;
}
