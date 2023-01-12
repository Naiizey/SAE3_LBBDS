#include <cjson/cJSON.h>
#include "pile.h"
#include "user.h"




Element * collectLivraison(cJSON * json);
int parcours(cJSON *json, File *liste, user * client);
cJSON * envoiLivraison(File *file, char * filter);