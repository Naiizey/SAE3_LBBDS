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

ajoutpA(pA_tab tab, int * offset, int type, char * nom){
    proprieteAttendu pA;
    pA.type=type;
    pA.nom=nom;
    tab[*offset]=pA;
    offset=offset+1;
}

typedef proprieteAttendu pA_tab[30];

int parcours(cJSON *json, pA_tab tab, int * offset){
    switch(json->type){
        case cJSON_Object:
            ajoutpA(tab,offset,cJSON_Object,json->string);
            if (json->child=NULL) return -1;
            parcours(json->child,tab,offset);
            break;
        case cJSON_Number:
            ajoutpA(tab,offset,cJSON_Number,json->string);
            break;
        case cJSON_String
        
    }
    
}

int buildconfig(){
    char buff[1024];
    int fd = open("config.json", O_RDONLY);
    read(fd,buff,1024);
    printf("Parsing...");
    cJSON *json = cJSON_Parse(buff);
    if(json == NULL) return -1;
        
  
    if(json->type == cJSON_Object){
        printf("Objet\n");
    }else if(json->type == cJSON_Number){
        printf("Number\n");
    }

  
    printf("\n");
}

int main(int argc, char const *argv[])
{
    creaJson();
    printf("%ld\n",time(NULL));
    
    return 0;
}
