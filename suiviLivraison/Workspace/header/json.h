#include <cjson/cJSON.h>
#include "file.h"
#include "user.h"




Element * collectLivraison(cJSON * json);
int parcoursPourLivraison(cJSON *json, File *liste, int *ind, int max);
int parcoursPourAuth(cJSON *json, user * client);
int parcours(cJSON *json, File *liste, user * client,int * indice, int max, int chercheLivr, int chercheAuth);
cJSON * envoiLivraison(File *file, char * filter, int * ind);