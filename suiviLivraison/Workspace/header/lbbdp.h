
#include "json.h"

#define ERROR_AUTH_MANQUANTE -21
#define ERROR_AUTH_INCORRECTE -22
#define ERROR_INTERNE -50




int handleAUT(cJSON * js, struct sockaddr addr, char * pathToFile);
int handleNEW(cJSON * new,File * liste,user * cli,int * capaLivraison,int maxCapaLivraison, struct sockaddr addr,char * pathToFile );
int handleACT(File * liste, int maxCapacite, int cnx,int time_day_sec);
int handleREP(cJSON * buf);