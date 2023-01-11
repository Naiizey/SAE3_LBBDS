#include<time.h>
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

void md5_hasher(char *string, char *hash);
bool verify_password(char *path, char *id, char *hashedPass);

