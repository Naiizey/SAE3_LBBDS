#include <time.h> 
#include <stdbool.h>


#ifndef ELEM_IS_DEF
typedef char t_etat[20];

typedef struct Elem
{
    int identifiant;
    time_t timestamp;
    t_etat etat;
    int joursRetard;
    struct Elem *suivant;
}Element;


typedef Element* File;
#endif
#define ELEM_IS_DEF

#ifndef MAX_CAPACITE_ATTEINT
#define MAX_CAPACITE_ATTEINT -2
#endif


//déclaration des fonctions
void initFile(File* file,int * indice);
Element create_element(int identifiant, time_t timestamp, char *etat, int joursRetard);
int enfiler(File *file, Element *nvElement, int * indice,int maxCapacitee);
Element * defiler(File *file, int * indice);
void afficherElement(Element *e, bool returnLine);
void afficherFile(File file);
void eraseFile(File *file);
File copier_file(File *file, File *file2, int maxCapacitee);
Element *trouverElement(File *file, int identifiant);
