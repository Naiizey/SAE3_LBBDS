#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <fcntl.h>
#include <unistd.h>

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
    //int typeReq;
    int type;
    char * nom;

} proprieteAttendu;
typedef proprieteAttendu pA_tab[30];


void ajoutpA(pA_tab tab, int * offset, int type, char * nom){
    proprieteAttendu pA;
    pA.type=type;
    pA.nom=nom;
    tab[*offset]=pA;
    *offset=*offset+1;
}


int parcours(cJSON *json, pA_tab tab, int * offset){
    switch(json->type){
        case cJSON_Object:
            ajoutpA(tab,offset,cJSON_Object,json->string);
            if (json->child==NULL || parcours(json->child,tab,offset) < 0) return -1;
            
            break;
        case cJSON_Number:
            ajoutpA(tab,offset,cJSON_Number,json->string);
            break;
        case cJSON_String:
            ajoutpA(tab, offset, cJSON_String, json->string);
            break;
        default:
            printf("Erreur: type non raccepté");
            return -1;
            break;

    }
    if(json->next!=NULL){
        return parcours(json->next,tab,offset);
    }else{
        return 0;
    }
    
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
    int retour = parcours(json, tab, &offset);
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
