#include <stdio.h>
#include <stdlib.h>
#include <time.h>



//fifo list
// - Identifiant livraison
// - Timestamp de la rentré dans le fifo
// - État de la livraison
// - Jours de retards
typedef struct fifo {
    int identifiant;
    time_t timestamp;
    char * etat; 
    int joursRetard;
    struct fifo *next;
} fifo;

//getters
int getIdentifiant(fifo *f) {
    return f->identifiant;
}

time_t getTimestamp(fifo *f) {
    return f->timestamp;
}

char *getEtat(fifo *f) {
    return f->etat;
}

int getJoursRetard(fifo *f) {
    return f->joursRetard;
}

//setters
void setIdentifiant(fifo *f, int identifiant) {
    f->identifiant = identifiant;
}

void setTimestamp(fifo *f, time_t timestamp) {
    f->timestamp = timestamp;
}

void setEtat(fifo *f, char *etat) {
    f->etat = etat;
}

void setJoursRetard(fifo *f, int joursRetard) {
    f->joursRetard = joursRetard;
}

// - Ajouter un élément dans la fifo
void addFifo(fifo *f, int identifiant, time_t timestamp, char *etat, int joursRetard) {
    //check if fifo is empty
    if (f == NULL) {
        f = malloc(sizeof(fifo));
        setIdentifiant(f, identifiant);
        setTimestamp(f, timestamp);
        setEtat(f, etat);
        setJoursRetard(f, joursRetard);
        f->next = NULL;
    }
    else
    {
        fifo *tmp = f;
        while (tmp->next != NULL) {
            tmp = tmp->next;
        }
        tmp->next = malloc(sizeof(fifo));
        setIdentifiant(tmp->next, identifiant);
        setTimestamp(tmp->next, timestamp);
        setEtat(tmp->next, etat);
        setJoursRetard(tmp->next, joursRetard);
        tmp->next->next = NULL;
    }        
}

// - Supprimer un élément de la fifo
void removeFifo(fifo *f) {
    fifo *tmp = f;
    f = f->next;
    free(tmp);
}

// - Afficher la fifo
void printFifo(fifo *f) {
    printf("Affichage de la fifo \n");
    // fifo *tmp = f;
    if (f == NULL) {
        printf("La fifo est vide \n");
    }
    else
    {
        while (f != NULL) {
            printf("Identifiant : %d - Timestamp : %ld - État : %s - Jours de retards : %d \n", getIdentifiant(f), getTimestamp(f), getEtat(f), getJoursRetard(f));
            f = f->next;
        }
    }

}

// - Vider la fifo
void emptyFifo(fifo *f) {
    fifo *tmp = f;
    while (tmp != NULL) {
        removeFifo(tmp);
        tmp = tmp->next;
    }
}

// - Sauvegarder la fifo dans un fichier
void saveFifo(fifo *f) {
    FILE *file = fopen("fifo.txt", "w");
    fifo *tmp = f;
    while (tmp != NULL) {
        fprintf(file, "Identifiant : %d - Timestamp : %ld - État : %s - Jours de retards : %d \n", getIdentifiant(tmp), getTimestamp(tmp), getEtat(tmp), getJoursRetard(tmp));
        tmp = tmp->next;
    }
    fclose(file);
}

// - Charger la fifo depuis un fichier
void loadFifo(fifo *f) {
    FILE *file = fopen("fifo.txt", "r");
    char line[100];
    while (fgets(line, 100, file) != NULL) {
        int identifiant = 0;
        time_t timestamp = 0;
        char etat[100];
        int joursRetard = 0;
        sscanf(line, "Identifiant : %d - Timestamp : %ld - État : %s - Jours de retards : %d \n", &identifiant, &timestamp, etat, &joursRetard);
        addFifo(f, identifiant, timestamp, etat, joursRetard);
    }
    fclose(file);
}

// - Récupérer la taille de la fifo
int getFifoSize(fifo *f) {
    int size = 0;
    fifo *tmp = f;
    while (tmp != NULL) {
        size++;
        tmp = tmp->next;
    }
    return size;
}

// - Récupérer un élément de la fifo
fifo *getFifo(fifo *f, int index) {
    fifo *tmp = f;
    int i = 0;
    while (i < index) {
        tmp = tmp->next;
        i++;
    }
    return tmp;
}

int main() {
    //print a text
    printf("Hello World \n");
    //create fifo
    fifo *f = NULL;
    //fill fifo
    addFifo(f, 1, time(NULL), "En cours", 0);
    addFifo(f, 2, time(NULL), "En cours", 0);
    addFifo(f, 3, time(NULL), "En cours", 0);
    addFifo(f, 4, time(NULL), "En cours", 0);
    addFifo(f, 5, time(NULL), "En cours", 0);
    //print fifo
    printFifo(f);
    //save fifo
    saveFifo(f);
    return 0;
} 