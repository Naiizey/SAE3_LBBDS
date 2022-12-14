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
    char res[10];
    int N = 0;
    bool onContinue = true;

    int opt;

    while (onContinue)
    {
        size = read(cnx, buf, 512);
        N++;
        if (strncmp(buf, "AVANCE\r", strlen("AVANCE\r")) == 0)
        {
            //On envoie la réponse
            write(cnx, "J'ai avancé\n", strlen("J'ai avancé\n"));
        }
        else if (strncmp(buf, "ETAT\r", strlen("ETAT\r")) == 0)
        {
            //On vide la string res
            memset(res, 0, sizeof(res));

            //On convertit N en string
            sprintf(res, "%d", N);
            strcat(res, "\n");

            //On envoie la réponse
            write(cnx, res, strlen(res));
        }
        else if (strncmp(buf, "LBBDS\r", strlen("LBBDS\r")) == 0)
        {
            //Tant qu'il y a des options à lire
            //L'argument de la fonction getopt() "a:b:c:d:" correspond aux différentes options disponibles 
            //Les : sont comme des slicers en python, ils signifient que suite à l'option il faut renseigner un mot
            //Exemple : ./simulateur -a -b <mot> -c <mot> -d <mot> -e <mot>
            //À noter que l'option a n'a pas de mot car il n'y a pas de : à sa suite dans l'argument de la fonction getopt()
            //Le mot est récupéré dans la variable optarg et n'est pas utilisable si l'option n'a pas de mot
            while ((opt = getopt(argc, argv, "ab:c:d:e:")) != -1)
            {
                //On vide la string res
                memset(res, 0, sizeof(res));

                switch (opt)
                {
                    case 'a':
                        strcat(res, "Option a reconnue");
                        break;
                    case 'b':
                        strcat(res, "Option b: ");
                        strcat(res, optarg);
                        break;
                    case 'c':
                        strcat(res, "Option c: ");
                        strcat(res, optarg);
                        break;
                    case 'd':
                        strcat(res, "Option d: ");
                        strcat(res, optarg);
                        break;
                    case 'e':
                        strcat(res, "Option e: ");
                        strcat(res, optarg);
                        break;
                    default:
                        strcat(res, "Option inconnue");
                        break;
                }
                strcat(res, "\n");

                //On envoie la réponse
                write(cnx, res, strlen(res));
            }
        }
        else if (strncmp(buf, "BYE\r", strlen("BYE\r")) == 0)
        {
            onContinue = false;
        }
    }

    return EXIT_SUCCESS;
}