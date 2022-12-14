#include <stdio.h>
#include <stdlib.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <fcntl.h>
#include <errno.h>
#include <string.h>
#include <unistd.h>
#include <stdbool.h>
#include <getopt.h>

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
            while ((opt = getopt(argc, argv, "abcd")) != -1)
            {
                switch (opt)
                {
                    case 'a':
                        write(cnx, "Option a\n", strlen("Option a\n"));
                        break;
                    case 'b':
                        write(cnx, "Option b\n", strlen("Option b\n"));
                        break;
                    case 'c':
                        write(cnx, "Option c\n", strlen("Option c\n"));
                        break;
                    case 'd':
                        write(cnx, "Option d\n", strlen("Option d\n"));
                        break;
                    default:
                        write(cnx, "Option inconnue\n", strlen("Option inconnue\n"));
                        break;
                }
            }
        }
        else if (strncmp(buf, "BYE\r", strlen("BYE\r")) == 0)
        {
            onContinue = false;
        }
    }

    return EXIT_SUCCESS;
}