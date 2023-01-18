#include <time.h> 
#include <stdbool.h>


#ifndef ELEM_IS_DEF
typedef char t_etat[20];
typedef char t_identifiant[30];

typedef struct Elem
{
    t_identifiant identifiant;
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
Element create_element(char * identifiant, time_t timestamp, char *etat, int joursRetard);
int enfiler(File *file, Element *nvElement, int * indice,int maxCapacitee);
Element * defiler(File *file, int * indice);
void afficherElement(Element *e, bool returnLine);
void afficherFile(File file);
void eraseFile(File *file);
int copier_file(File *file, File *file2, int maxCapacitee);
int copier_file_tr(File *file, File *file2,File * tri, int maxCapacitee,int time_day_sec, bool (*critereTri)(Element, void *));
int trie_file(File *file, File * tri,int * capaLivraison, void * arg, bool (*critereTri)(Element, void *));
Element *trouverElement(File *file, char * identifiant);
void fusion(File * file1, File * file2,File * retour);
