#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>

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
    int typeReq;
    int type;
    char * nom;

} proprieteAttendu;

void creaJson(){
    const char * a = "{\"oui\" : 1 }";
    cJSON *json = cJSON_Parse(a);
    if(json == NULL){
        printf("Nique !\n");
    }
    printf(cJSON_Print(json));
    if(json->type == cJSON_Object){
        printf("Objet\n");
    }else if(json->type == cJSON_Number){
        printf("Number\n");
    }

    if(json->child->type == cJSON_Object){
        printf("Objet");
    }else if(json->child->type == cJSON_Number){
        printf("%d\n",json->child->valueint);
    }
    printf("\n");
}

int main(int argc, char const *argv[])
{
    creaJson();
    
    return 0;
}
