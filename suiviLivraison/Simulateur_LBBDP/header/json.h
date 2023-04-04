#include "cJSON.h"
#include "fifo.h"
#include "user.h"



Livraison * collectLivraison(cJSON * json);
int parcoursPourLivraison(cJSON *json, File *liste);
int parcoursPourAuth(cJSON *json, user * client);
int parcours(cJSON *json, File *liste, user * client, int chercheLivr, int chercheAuth);
cJSON * envoiLivraison(File *file, char * filter);