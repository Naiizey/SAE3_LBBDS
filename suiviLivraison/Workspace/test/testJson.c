
#include <cjson/cJSON.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <unistd.h>
#include <stdbool.h>
#include <string.h>
#include <unistd.h>
#include <fcntl.h>


#include "json.h"
#define TEST true


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
        
        File liste;
        initFile(&liste);

        
        int retour = parcours(json,&liste);
        if(retour != -1){
            //sleep(2);
            cJSON * oui = envoiLivraison(&liste,"");
            printf(cJSON_Print(oui));
            printf("\n");

        }
       
       

    }

   
    
    return 0;
}
