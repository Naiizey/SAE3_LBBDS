#include <stdio.h>
#include <stdlib.h>
#include <stdbool.h>
#include <string.h>
#include "file.h"



void initFile(File* f,int * indice){
    if (indice!=NULL)
        (*indice)=0;
    (*f) = NULL;
}
//getters
char * getIdentifiant(Element *e) {
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

void setIdentifiant(Element *e, char * identifiant) {
    strcpy(e->identifiant, identifiant);
}

void setTimestamp(Element *e, time_t timestamp) {
    e->timestamp = timestamp;
}

void setEtat(Element *e, char *etat) {
    strcpy(e->etat , etat);
}

Element create_element(char * identifiant, time_t timestamp, char *etat, int joursRetard) {
    Element *e = malloc(sizeof(*e));
    setIdentifiant(e, identifiant);
    setTimestamp(e, timestamp);
    setEtat(e, etat);
    e->joursRetard = joursRetard;
    e->suivant = NULL;
    return *e;
}

void copie_element( Element * copie, Element sujet){
    strcpy(copie->identifiant , sujet.identifiant);
    copie->timestamp = sujet.timestamp;
    strcpy(copie->etat , sujet.etat);
    copie->joursRetard = sujet.joursRetard;
    copie->suivant = NULL;
}

int enfiler(File *file, Element *nvElement, int *indice, int maxCapacitee)
{
    Element *nouveau = malloc(sizeof(*nouveau));
    if (file == NULL || nouveau == NULL)
    {
        return -1;
    }else if( indice != NULL && maxCapacitee<(*indice)){
        return MAX_CAPACITE_ATTEINT;
    }


    strcpy(nouveau->identifiant,nvElement->identifiant);
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
            elementActuel = elementActuel->suivant;
        }
        elementActuel->suivant = nouveau;
    }
    else /* La file est vide, notre élément est le premier */
    {
        *file = nouveau;
    }
    if (indice != NULL)
        (*indice)=(*indice)+1;

    return 0;
}
 /**
  * @brief Enfile sans contrainte de capacité
  * @ref enfiler
  * 
  * @param file 
  * @param nvElement 
  * @return int 
  */
int enfilerSimple(File *file, Element *nvElement)
{
    Element *nouveau = malloc(sizeof(*nouveau));
    if (file == NULL || nouveau == NULL)
    {
        return -1;
    }


    strcpy(nouveau->identifiant , nvElement->identifiant);
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
            elementActuel = elementActuel->suivant;
        }
        elementActuel->suivant = nouveau;
    }
    else /* La file est vide, notre élément est le premier */
    {
        *file = nouveau;
    }
   

    return 0;
}


int soft_enfiler(File *file, Element *nvElement)
{
    Element *nouveau = malloc(sizeof(*nouveau));
    if (file == NULL || nouveau == NULL)
    {
        return -1;
    }

    

    if ((*file) != NULL) /* La file n'est pas vide */
    {
        /* On se positionne à la fin de la file */
        Element *elementActuel = *file;
        while (elementActuel->suivant != NULL)
        {
            elementActuel = elementActuel->suivant;
        }
        elementActuel->suivant = nvElement;
    }
    else /* La file est vide, notre élément est le premier */
    {
        *file = nvElement;
    }
  
    return 0;
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

Element * defiler(File *file, int *indice)
{
    Element *temp =(Element *) malloc(sizeof(Element));

    /* On vérifie s'il y a quelque chose à défiler */
    if((*file) == NULL)
    {
        temp=NULL;
    }
    else if((*file)->suivant==NULL)
    {
        temp = (*file);
        copie_element(temp,**file);
        (*file)=NULL;
        if(indice != NULL)
            (*indice)=(*indice)-1;
    }
    else 
    {

        Element * elementDefile=(*file);
        copie_element(temp,*elementDefile);
        (*file) = elementDefile->suivant;
        //free(elementDefile);
        if(indice != NULL)
            (*indice)=(*indice)-1;

        
    }
    afficherElement(temp,true);
  
    return temp;

}

void afficherElement(Element *e, bool returnLine)
{
    if(e == NULL)
    {
        printf("estVide");
    }
    else
    {
        printf("%s ,%s ,%d ,%ld -> \n", e->identifiant, e->etat, e->joursRetard, e->timestamp);
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

Element *trouverElement(File *file, char * identifiant)
{
    if (file == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    actuel = (*file);

    while (actuel != NULL)
    {
        if (strcmp(actuel->identifiant , identifiant)==0)
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
int copier_file(File *file, File *file2, int maxCapacitee)
{
    int ind;
   
    if (file == NULL || file2 == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    actuel = (*file);

    while (actuel != NULL)
    {
        printf("enfilage élement\n");
        enfiler(file2, actuel, &ind, maxCapacitee);
        actuel = actuel->suivant;
    
    }
    return ind;
}


/**
* @brief copier_file copie une file dans une autre
* @param file la file à copier
* @param file2 la file dans laquelle on copie
* @return la file2
*/
void copier_file_simple(File *file, File *file2)
{
   
    if (file == NULL || file2 == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    actuel = (*file);

    while (actuel != NULL)
    {
        printf("enfilage élement\n");
        enfilerSimple(file2, actuel);
        actuel = actuel->suivant;
    
    }
   
}



int copier_file_tr(File *file, File *file2,File * tri ,int maxCapacitee,int time_day_sec, bool (*critereTri)(Element, void *))
{
    int ind=0;
    if (file == NULL || file2 == NULL || tri == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    Element * removed;
    actuel = (*file);

    while (actuel != NULL)
    {
        printf("enfilage élement -> ");
        if((*critereTri)(*actuel, &time_day_sec)){
            printf("trié");
            //ATTENTION: on part du principe qu'aucune livraison n'as de "retard"
            removed=defiler(file,NULL);//On n'enlève pas dans indice, car pour l'instant la place n'est pas libéré
            enfilerSimple(tri, removed);  
        }else{
            printf("non trié");
            enfiler(file2, actuel, &ind, maxCapacitee);
        }
        printf("\n");
        actuel = actuel->suivant;
        
    }
    return ind;
}

int trie_file(File *file, File * tri,int * capaLivraison, void * arg, bool (*critereTri)(Element, void *))
{
    int ind=0;
    
    if (file == NULL || tri == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel;
    actuel = (*file);

    while (actuel != NULL)
    {
        
        if((*critereTri)(*actuel, arg)){
            printf("trié\n");
            enfilerSimple(tri, actuel);  
            if(capaLivraison != NULL){
                (*capaLivraison)=(*capaLivraison)-1;
            }
        }

        actuel = actuel->suivant;
        ind++;
    }
    return ind;
}

void fusion(File * file1, File * file2,File * retour){
  
    if(retour==NULL){
        exit(EXIT_FAILURE);
    }
    copier_file_simple(file1, retour);
    copier_file_simple(file2, retour);

 
}

