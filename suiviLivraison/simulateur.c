#include <stdio.h>
#include <stdlib.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <fcntl.h>
#include <errno.h>
#include <string.h>
#include <unistd.h>
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

    //On créé un tableau de structures pour stocker les options
    struct option
    {
        char *name;
        char *value;
    };
    struct option options[5];

    //Tant qu'il y a des options à lire
    //L'argument de la fonction getopt() "a:b:c:d:" correspond aux différentes options disponibles 
    //Les : sont comme des slicers en python, ils signifient que suite à l'option il faut renseigner un mot
    //Exemple : ./simulateur -a -b <mot> -c <mot> -d <mot> -e <mot>
    //À noter que l'option a n'a pas de mot car il n'y a pas de : à sa suite dans l'argument de la fonction getopt()
    //Le mot est récupéré dans la variable optarg et n'est pas utilisable si l'option n'a pas de mot
    int i = 0;
    int opt;
    while ((opt = getopt(argc, argv, "ab:c:d:e:")) != -1)
    {
        switch (opt)
        {
            case 'a':
                options[i].name = "a";
                options[i].value = NULL;
                break;
            case 'b':
                options[i].name = "b";
                options[i].value = optarg;
                break;
            case 'c':
                options[i].name = "c";
                options[i].value = optarg;
                break;
            case 'd':
                options[i].name = "d";
                options[i].value = optarg;
                break;
            case 'e':
                options[i].name = "e";
                options[i].value = optarg;
                break;
            default:
                options[i].name = "inconnue";
                options[i].value = NULL;
                break;
        }
        i++;
    }

    //Fonction read() et write() 
    //On initialise les variables
    char buf[512];
    char res[10];
    int N = 0;
    int onContinue = 1;

    //Tant que le client ne nous envoie pas "BYE\r"
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
            //Parcours des options sauvegardées en fonction de la longueur du tableau des options sauvegardées
            for (int i = 0; i < sizeof(options) / sizeof(options[0]); i++)
            {
                //On vide la string res
                memset(res, 0, sizeof(res));
                strcat(res, "Option ");
                strcat(res, options[i].name);
                
                //Si l'option a un mot, on l'affiche
                if (options[i].value != NULL)
                {
                    strcat(res, ": ");
                    strcat(res, options[i].value);
                }
                //Si l'option n'a pas de mot et qu'elle n'en requiert pas
                else if (strcmp(options[i].name, "inconnue") != 0)
                {
                    strcat(res, " reconnue");
                }
                strcat(res, "\n");

                //On envoie la réponse
                write(cnx, res, strlen(res));
            }
        }
        else if (strncmp(buf, "BYE\r", strlen("BYE\r")) == 0)
        {
            onContinue = 0;
        }
    }

    return EXIT_SUCCESS;
}