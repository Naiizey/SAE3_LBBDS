#include <stdio.h>
#include <openssl/md5.h>
#include <string.h>
#include <stdbool.h>

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

int main()
{
    char path[255] = "/home/florian/giveSim";

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
