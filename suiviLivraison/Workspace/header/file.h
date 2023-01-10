#include <time.h> 
#include <stdbool.h>


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

//déclaration des fonctions
void initFile(File* file);
Element create_element(int identifiant, time_t timestamp, char *etat, int joursRetard);
void enfiler(File *file, Element *nvElement);
Element * defiler(File *file);
void afficherElement(Element *e, bool returnLine);
void afficherFile(File file);
void eraseFile(File *file);
File copier_file(File *file, File *file2);
Element *trouverElement(File *file, int identifiant);
