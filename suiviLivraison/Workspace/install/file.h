#include <time.h> 

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
