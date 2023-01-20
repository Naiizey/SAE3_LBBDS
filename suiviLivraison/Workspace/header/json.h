#include <cjson/cJSON.h>
#include "fifo.h"
#include "user.h"



Livraison * collectLivraison(cJSON * json);
int parcoursPourLivraison(cJSON *json, File *liste, int *ind, int max);
bool checkDestinataire(Element e, void * time_day_sec);
int parcoursPourAuth(cJSON *json, user * client);
int parcours(cJSON *json, File *liste, user * client,int * indice, int max, int chercheLivr, int chercheAuth);
cJSON * envoiLivraison(File *file, char * filter, int * ind,int time_day_sec);