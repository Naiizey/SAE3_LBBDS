#include<time.h>
#include <openssl/md5.h>

#include <sys/socket.h>
#include <arpa/inet.h>


#ifndef USER_IS_DEF
typedef struct us {
    char * id;
    char * pass;
    time_t session;
    struct sockaddr addr;
} user;

typedef user * arrayUser;
#endif
#define USER_IS_DEF


char * getIp(struct sockaddr adr);
void md5_hasher(char *string, char *hash);
int verify_password(char *path, char *id, char *hashedPass);
int connection(user * client, struct sockaddr addr, arrayUser arr, int *ind,int * max, char * mdpFile);
void * init_array_session(int max_array);
user * IPdejaConnecte(arrayUser arr,int ind,struct sockaddr adr);

