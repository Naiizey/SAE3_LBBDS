#include <stdio.h>
#include <stdbool.h>
#include "user.h"

char * path = "./giveSim";

int main()
{
    
    

    char password[255] = "mdAdfbnrRtps";
    char id[55] = "153";

    char md5_hash[2*MD5_DIGEST_LENGTH+1] = "";

    printf("Path: %s\n", path);

    md5_hasher(password, md5_hash);
    printf("Hash: %s\n", md5_hash);

    if(verify_password(path, id, md5_hash)){
        printf("ID et Password trouvés\n");
    }

    


    return 0;
}