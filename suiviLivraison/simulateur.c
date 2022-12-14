/**
 * @author AUBRY Mathis
 * @brief
 */

#include <stdio.h>
#include <stdlib.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <fcntl.h>
#include <errno.h>
#include <string.h>
#include <unistd.h>
#include <stdbool.h>

int main(int argc, char *argv[])
{
    //Fonction socket() - Client et Serveur
    int sock;
    sock = socket(AF_INET, SOCK_STREAM, 0);
    if (sock == -1)
    {
        perror("Handler échoué");
    }

    //Fonction bind() - Serveur seulement
    int ret;
    struct sockaddr_in addr;
    addr.sin_addr.s_addr = inet_addr("127.0.0.1");
    addr.sin_family = AF_INET;
    addr.sin_port = htons(8080);
    ret = bind(sock, (struct sockaddr *)&addr, sizeof(addr));
    if (ret != 0)
    {
        perror("Nommage du socket échoué");
    }

    //Fonction listen() - Serveur seulement
    ret = listen(sock, 1);
    if (ret != 0)
    {
        perror("Écoute échouée");
    }

    //Fonction accept() - Serveur seulement
    int size;
    int cnx;
    struct sockaddr_in conn_addr;
    size = sizeof(conn_addr);
    cnx = accept(sock, (struct sockaddr *)&conn_addr, (socklen_t *)&size);
    if (cnx == -1)
    {
        perror("Connexion échouée");
    }

    //Fonction read() et write() (exo2et3)
    char buf[512];
    char Ns[10];
    int N = 0;
    bool onContinue = true;

    int opt;

    while (onContinue)
    {
        size = read(cnx, buf, 512);
        N++;
        if (strncmp(buf, "AVANCE\r", strlen("AVANCE\r")) == 0)
        {
            
            write(cnx, "J'ai avancé\n", strlen("J'ai avancé\n"));
        }
        else if (strncmp(buf, "ETAT\r", strlen("ETAT\r")) == 0)
        {
            sprintf(Ns, "%d", N);
            strcat(Ns, "\n");
            write(cnx, Ns, strlen(Ns));
        }
        else if (strncmp(buf, "OPT\r", strlen("OPT\r")) == 0)
        {
            // put ':' in the starting of the
            // string so that program can 
            //distinguish between '?' and ':' 
            while((opt = getopt(argc, argv, ":if:lrx")) != -1)
            {
                switch(opt)
                {
                    case 'i':
                    case 'l':
                    case 'r':
                        printf("option: %c\n", opt);
                        break;
                    case 'f':
                        printf("filename: %s\n", optarg);
                        break;
                    case ':':
                        printf("option needs a value\n");
                        break;
                    case '?':
                        printf("unknown option: %c\n", optopt);
                        break;
                }
            }
     
            //optind is for the extra arguments
            //which are not parsed
            for (int optind = 0; optind < argc; optind++)
            {
                printf("extra arguments: %s\n", argv[optind]);
            }
        }
        else if (strncmp(buf, "BYE\r", strlen("BYE\r")) == 0)
        {
            onContinue = false;
        }
    }

    return EXIT_SUCCESS;
}