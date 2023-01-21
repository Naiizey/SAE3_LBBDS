
#include "json.h"


#define REUSSITE 00
#define REUSSITE_RET 01
#define REUSSITE_ENATT 02

#define ERR_PROTOC -10
#define ERR_PROTOC_OPINCONUE -11

#define ERR_AUTH -20
#define ERR_AUTH_MANQUANTE -21
#define ERR_AUTH_INCONNUE -22

#define ERR_LOGI -30
#define ERR_LOGI_FPLEINE -31

#define ERR_JSON -40
#define ERR_JSON_NORME -41
#define ERR_JSON_CONTENU -42

#define ERR_INTERNE -50




int handleAUT(cJSON * js, struct sockaddr addr, char * pathToFile);
int handleNEW(cJSON * new,File * liste,user * cli, struct sockaddr addr,char * pathToFile );
int handleACT(File  * liste, int cnx);
int handleREP(cJSON * rep,File * liste);
