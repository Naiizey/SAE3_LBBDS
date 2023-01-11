#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>
#include "file.h"



void initFile(File* f){
   (*f) = NULL;
}
//getters
int getIdentifiant(Element *e) {
    return e->identifiant;
}

time_t getTimestamp(Element *e) {
    return e->timestamp;
}

char *getEtat(Element *e) {
    return e->etat;
}

int getJoursRetard(Element *e) {
    return e->joursRetard;
}

//setters
void setIdentifiant(Element *e, int identifiant) {
    e->identifiant = identifiant;
}

void setTimestamp(Element *e, time_t timestamp) {
    e->timestamp = timestamp;
}

void setEtat(Element *e, char *etat) {
    strcpy(e->etat , etat);
}

Element create_element(int identifiant, time_t timestamp, char *etat, int joursRetard) {
    Element *e = malloc(sizeof(*e));
    setIdentifiant(e, identifiant);
    setTimestamp(e, timestamp);
    setEtat(e, etat);
    e->joursRetard = joursRetard;
    e->suivant = NULL;
    return *e;
}

void enfiler(File *file, Element *nvElement)
{
    Element *nouveau = malloc(sizeof(*nouveau));
    if (file == NULL || nouveau == NULL)
    {
        exit(EXIT_FAILURE);
    }
    printf("oh!\n");

    nouveau->identifiant = nvElement->identifiant;
    nouveau->timestamp = nvElement->timestamp;
    strcpy(nouveau->etat , nvElement->etat);
    nouveau->joursRetard = nvElement->joursRetard;
    nouveau->suivant = NULL;
    

    if ((*file) != NULL) /* La file n'est pas vide */
    {
        /* On se positionne à la fin de la file */
        Element *elementActuel = *file;
        while (elementActuel->suivant != NULL)
        {
            printf("là!\n");
            elementActuel = elementActuel->suivant;
        }
        elementActuel->suivant = nouveau;
    }
    else /* La file est vide, notre élément est le premier */
    {
        *file = nouveau;
    }
}

void eraseFile(File *file)
{
    //on détruit la file
    Element *elementActuel = (*file);
    while (elementActuel != NULL)
    {
        Element *temp = elementActuel;
        elementActuel = elementActuel->suivant;
        free(temp);
    }
    (*file) = NULL;
}

Element * defiler(File *file)
{


    
    
  

    /* On vérifie s'il y a quelque chose à défiler */
    if ((*file) != NULL && (*file)->suivant!=NULL)
    {

        Element *temp =(Element *) malloc(sizeof(Element));
        Element * elementDefile;
        elementDefile = (*file);
        temp = (*file);
        (*file) = elementDefile->suivant;
        free(elementDefile);

        return temp;
        
    }
    else
    {
        return NULL;
    }


}

void afficherElement(Element *e, bool returnLine)
{
    if(e == NULL)
    {
        printf("estVide");
    }
    else
    {
        printf("%d ,%s ,%d ,%ld -> \n", e->identifiant, e->etat, e->joursRetard, e->timestamp);
        if (returnLine)
        {
            printf(" \n");
        }
    }
    
}

void afficherFile(File file)
{
    if (file == NULL)
    {
        printf("non !\n");
    }

    Element *actuel;
    actuel = file;

    while (actuel != NULL)
    {
        afficherElement(actuel, true);
        actuel = actuel->suivant;
    }
}

Element *trouverElement(File *file, int identifiant)
{
    if (file == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    actuel = (*file);

    while (actuel != NULL)
    {
        if (actuel->identifiant == identifiant)
        {
            return actuel;
        }
        actuel = actuel->suivant;
    }
    return NULL;
}

/**
* @brief copier_file copie une file dans une autre
* @param file la file à copier
* @param file2 la file dans laquelle on copie
* @return la file2
*/
File copier_file(File *file, File *file2)
{
    if (file == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    actuel = (*file);

    while (actuel != NULL)
    {
        enfiler(file2, actuel);
        actuel = actuel->suivant;
    }
    return *file2;
}

