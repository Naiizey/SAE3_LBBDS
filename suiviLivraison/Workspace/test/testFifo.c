#include "file.h"
#include <stdlib.h>
#include <stdio.h>


int main(int argc, char *argv[])
{
    File file = NULL;

    //creation d'un element
    Element *e = malloc(sizeof(*e));
    *e = create_element(1, time(NULL), "en cours", 0);
    afficherElement(e, true);
    enfiler(&file, e);
    afficherFile(&file);
    

    //defiler
    // Element *temp = malloc(sizeof(*temp));
    // *temp = defiler(&file);
    // afficherElement(temp,true);

    //copier file
    File file2 = {NULL};
    printf("\ncopie de file dans file2 \n");
    copier_file(&file, &file2);
    printf("file2 : \n");
    afficherFile(&file2);
    //vide file1
    printf("vider file1 \n");
    eraseFile(&file);
    printf("file1 : \n");
    afficherFile(&file);
    printf("\n");
    printf("file2 : \n");
    afficherFile(&file2);
    printf("\n");

    Element *e2 = malloc(sizeof(*e2));
    //on touvre l'element 1
    *e2 = *trouverElement(&file2, 1);
    printf("element 1 trouvé: \n");
    afficherElement(e2, true);


    return 0;
}