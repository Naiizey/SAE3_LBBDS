#include "fifo.h"
#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>

/*
int main(int argc, char *argv[])
{
    File file = NULL;
    int maxCapacite=6;
    int ind=0;

    Element * temp;

    //creation d'un element
    Element *e = malloc(sizeof(*e));
    *e = create_element("1", time(NULL), "en cours", 0);
    afficherElement(e, true);
    enfiler(&file, e, &ind, maxCapacite);
    afficherFile(file);
    

    //defiler
    // Element *temp = malloc(sizeof(*temp));
    //temp = defiler(&file,&ind);
    //afficherElement(temp,true);

    //copier file
    File file2 = {NULL};
    printf("\ncopie de file dans file2 \n");
    copier_file(&file, &file2, maxCapacite);
    printf("file2 : \n");
    afficherFile(file2);
    //vide file1
    printf("vider file1 \n");
    eraseFile(&file);
    printf("file1 : \n");
    afficherFile(file);
    printf("\n");
    printf("file2 : \n");
    afficherFile(file2);
    printf("\n");

    Element *e2 = malloc(sizeof(*e2));
    //on touvre l'element 1
    *e2 = *trouverElement(&file2, "1");
    printf("element 1 trouvé: \n");
    afficherElement(e2, true);


    return 0;
}
*/



int main(int argc, char const *argv[])
{
    int time_day_sec=3;
    File maFile;
    initialisationFile(&maFile,NULL);
    ajoutFile(&maFile,createLivraison("1",time(NULL),"en charge"));
    ajoutFile(&maFile,createLivraison("5",time(NULL),"en charge"));
    ajoutFile(&maFile,createLivraison("9",time(NULL),"en charge"));
  
    printf("Vide ? :  %s\n",(estFileVide(maFile)) ? "Vrai":"Faux");
    afficherLivraison(observerTete(maFile));
    Livraison coucou=observerTete(maFile);
     printf("Observer:\n");
    afficherLivraison(coucou);
    sleep(5);
    afficherLivraison(observerTete(maFile));
    retraitFile(&maFile,time_day_sec);
    afficherLivraison(retraitFile(&maFile,time_day_sec));
    retraitFile(&maFile,time_day_sec);
    printf("Vide ? :  %s\n",(estFileVide(maFile)) ? "Vrai":"Faux");

     printf("Retrait:\n");
    afficherLivraison(coucou);
    return 0;

    


}
