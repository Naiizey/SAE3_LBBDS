#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <ctype.h>
#include "fifo.h"


const int TEMPS_MAX_REGIONAL=3;
const int TEMPS_LOCAL=1;
#define MAX_ETAPE 4


char EN_CHARGE[10]= "en charge";
char REGIONAL[9] = "regional";
char LOCAL[6] = "local";
char DESTINATAIRE[13] = "destinataire";
int MAX_LONG_NOM_ETAT=15;


/**
 * @brief Fait las liaison entre un état et un nombre de jour
 * 
 */
typedef struct {
    char * nom;
    int apresXjour;
} etatLivraison;


typedef etatLivraison etats[MAX_ETAPE];
const etats quelEtape = {
    {EN_CHARGE,0},
    {REGIONAL,TEMPS_MAX_REGIONAL},
    {LOCAL,TEMPS_MAX_REGIONAL+TEMPS_LOCAL},
    {DESTINATAIRE,ETAT_FINAL}

};


 /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                        La livraison                                             ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */
void setIdentifiant(Livraison *e, char * identifiant) {
    strcpy(e->identifiant, identifiant);
}

void setTimestamp(Livraison *e, time_t timestamp) {
    e->timestamp = timestamp;
}

void setEtat(Livraison *e, char *etat) {
    strcpy(e->etat , etat);
}
Livraison createLivraison(char * identifiant, time_t timestamp, char *etat) {
    Livraison *e = malloc(sizeof(*e));
    setIdentifiant(e, identifiant);
    setTimestamp(e, timestamp);
    setEtat(e, etat);
    e->jours = 0;
    return *e;
}

void afficherLivraison(Livraison livr)
{
    printf("%s : (en \"jours\": %d , en secondes: %ld) -> %s \n", livr.identifiant,  livr.jours, livr.timestamp, livr.etat);
        
}


  

/**
 * @brief Retourne le nombre de jour avant la fin d'un état, si celui-ci existe.
 * 
 * @param etat 
 * 
 * 
 * @return true 
 * @return false 
 */
int verifEtat(char * in){
    char etat[MAX_LONG_NOM_ETAT];
    strcpy(etat, in);
    for(int i=0;i<strlen(etat) && i<MAX_LONG_NOM_ETAT;i++){
        etat[i]=(char)tolower((int)etat[i]);
    }
  
    
    bool trouve=false;
    int i=0;
    while(i<MAX_ETAPE && !trouve){
        trouve=(strcmp(quelEtape[i].nom,etat)==0);
        i++;
    }
    if(trouve){
        i--;
        return quelEtape[i].apresXjour;
    }
    else{
        return ERR_ETAT;
    }
}

/**
 * @brief Permet de retourner l'état en fonction de l'état d'entré du simulateur et de temps passé.
 * 
 * @param etat état à l'entrée du simulateur 
 * @param jour état passé dans le simulateur
 * @return const char* 
 */
const char * traitementEtat(char * etat, int jour){
    bool trouve=false;
    int i=0;
    while( i<MAX_ETAPE && !trouve){
        trouve=quelEtape[i].apresXjour==ETAT_FINAL || quelEtape[i].apresXjour >= jour;
        i++;
    }
    if(trouve)
    {
        i--;
        return quelEtape[i].nom;
    }
    else
        return NULL;
    
}  

/**
 * @brief Retourne en seconde la différence entre deux temps
 * 
 * @param avant 
 * @param maintenant 
 * @return int - duree en jour entre maj
 */
void maJourEtat(Livraison * livr, time_t maintenant, int time_day_sec){
    time_t diff = difftime(maintenant, livr->timestamp);
    livr->jours=diff/time_day_sec;
    strcpy(livr->etat,traitementEtat("",livr->jours));
 
}

bool checkDestinataire(Livraison livr, int time_day_sec){
    maJourEtat( &livr,time(NULL), time_day_sec);
    return livr.jours >TEMPS_MAX_REGIONAL+TEMPS_LOCAL;
}


 /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                        Les livraisons / File                                    ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */

void initialisationFile(File * f,int timeDaySec,int * maxCapacite){
    f->queue=NULL;
    f->tete=NULL;
    f->timeDaySec=timeDaySec;
    f->indice=0;
    f->maxCapacite=maxCapacite;
}



int estFileVide(File f){
    return (f.queue==NULL && f.tete==NULL);
}

int estMaxAtteint(File *f, int ajout){
    int retour=(f->maxCapacite!=NULL && *(f->maxCapacite)<=(f->indice+ajout));
    if(!retour){
        f->indice=f->indice+ajout;
    }
    return retour;
}

Livraison checkTete(File f){
    Livraison retour;
    if(estFileVide(f))
    {
        printf("Erreur file vide\n");
        retour=createLivraison("@", -time(NULL), "corrompu");
    }
    else
    {
        retour=f.tete->livraison;
    }
    return retour;
}

void observerTete(File f){
    if(estFileVide(f))
    {
        printf("vide ->\n");
    }
    else
    {
        afficherLivraison(checkTete(f));
    }
    
}

int ajoutFile(File *f, Livraison livr){
    Element * nouveau = (Element *)malloc(sizeof(Element));
    nouveau->livraison=livr;
    nouveau->suivant=NULL;
    int retour;

    retour= estMaxAtteint(f,1);

    if(!retour)
    {
        if(estFileVide(*f))
        {
            f->queue=nouveau;
            f->tete=nouveau;
        }
        else 
        {
            f->queue->suivant=nouveau;
            f->queue=nouveau;
        }
    }
    
    return retour;
    
}



Livraison * retraitFile(File *f){
    Element * curr;
    Livraison * retour;
    if(estFileVide(*f))
    {
        retour=NULL;
    }
    else
    {
        retour=(Livraison *)malloc(sizeof(Livraison));
        if(f->queue==f->tete){
            curr=f->tete;
            *retour=curr->livraison;
            f->queue=NULL;
            f->tete=NULL;
            free(curr);
        }
        else{
            curr=f->tete;
            *retour=curr->livraison;
            f->tete=f->tete->suivant;
            free(curr);

        }
        maJourEtat(retour,time(NULL),f->timeDaySec);
        f->indice=f->indice-1;
    }
    

    return retour;
}






void afficherFile(File file)
{
    if (estFileVide(file))
    {
        printf("non !\n");
    }

    Element *actuel;
    actuel = file.tete;

    while (actuel != NULL)
    {
        afficherLivraison(actuel->livraison);
        actuel = actuel->suivant;
    }
}

Element *trouverElement(File file, char * identifiant)
{
    if (estFileVide(file))
    {
        return NULL;
    }

    Element *actuel;
    actuel = file.tete;

    while (actuel != NULL)
    {
        if (strcmp(actuel->livraison.identifiant , identifiant)==0)
        {
            return actuel;
        }
        actuel = actuel->suivant;
    }
    return NULL;
}


