#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <stdbool.h>

typedef struct Element Element;
struct Element
{
    int identifiant;
    time_t timestamp;
    char *etat;
    int joursRetard;
    Element *suivant;
};

typedef struct File File;
struct File
{
    Element *premier;
};

//déclaration des fonctions
Element create_element(int identifiant, time_t timestamp, char *etat, int joursRetard);
void enfiler(File *file, Element *nvElement);
Element defiler(File *file);
void afficherElement(Element *e, bool returnLine);
void afficherFile(File *file);
void eraseFile(File *file);
File copier_file(File *file, File *file2);
Element *trouverElement(File *file, int identifiant);

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
    e->etat = etat;
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

    nouveau->identifiant = nvElement->identifiant;
    nouveau->timestamp = nvElement->timestamp;
    nouveau->etat = nvElement->etat;
    nouveau->joursRetard = nvElement->joursRetard;
    nouveau->suivant = NULL;
    

    if (file->premier != NULL) /* La file n'est pas vide */
    {
        /* On se positionne à la fin de la file */
        Element *elementActuel = file->premier;
        while (elementActuel->suivant != NULL)
        {
            elementActuel = elementActuel->suivant;
        }
        elementActuel->suivant = nouveau;
    }
    else /* La file est vide, notre élément est le premier */
    {
        file->premier = nouveau;
    }
}

void eraseFile(File *file)
{
    //on détruit la file
    Element *elementActuel = file->premier;
    while (elementActuel != NULL)
    {
        Element *temp = elementActuel;
        elementActuel = elementActuel->suivant;
        free(temp);
    }
    file->premier = NULL;
}

Element defiler(File *file)
{
    if (file == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *temp = malloc(sizeof(*temp));
    
    

    /* On vérifie s'il y a quelque chose à défiler */
    if (file->premier != NULL)
    {
        Element *elementDefile = file->premier;
        *temp = *file->premier;
        file->premier = elementDefile->suivant;
        afficherFile(file);
        printf("\n");
        free(elementDefile);
        afficherFile(file);
        printf("\n");
    }

    return *temp;
}

void afficherElement(Element *e, bool returnLine)
{
    printf("%d ,%s ,%d ,%ld -> ", e->identifiant, e->etat, e->joursRetard, e->timestamp);
    if (returnLine)
    {
        printf(" \n");
    }
}

void afficherFile(File *file)
{
    if (file == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel = file->premier;

    while (actuel != NULL)
    {
        afficherElement(actuel, false);
        actuel = actuel->suivant;
    }
}

Element *trouverElement(File *file, int identifiant)
{
    if (file == NULL)
    {
        exit(EXIT_FAILURE);
    }

    Element *actuel = file->premier;

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

/*
* copier_file copie une file dans une autre
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

    Element *actuel = file->premier;

    while (actuel != NULL)
    {
        enfiler(file2, actuel);
        actuel = actuel->suivant;
    }
    return *file2;
}

int main(int argc, char *argv[])
{
    File file = {NULL};

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