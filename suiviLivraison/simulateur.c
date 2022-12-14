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
    /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                                   Options                                       ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */

    //On créé un tableau de structures pour stocker les options
    struct option
    {
        char *name;
        char *value;
    };
    struct option options[20]; //Renseigner ici le nombre maximum d'options

    //Tant qu'il y a des options à lire
    //L'argument de la fonction getopt() "a:b:c:d:" correspond aux différentes options disponibles 
    //Les : sont comme des slicers en python, ils signifient que suite à l'option il faut renseigner une valeur (ou attribut lié à l'option)
    //Exemple : ./simulateur -a -b <valeur> -c <valeur> -d <valeur> -e <valeur>
    //À noter que l'option a n'a pas de valeur car il n'y a pas de : à sa suite dans l'argument de la fonction getopt()
    //Le mot est récupéré dans la variable optarg et n'est pas utilisable si l'option n'a pas de valeur
    int opt, i = 0, nbArguments = 0;
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
                //On laisse getopt gérer les erreurs dans ce cas
                exit(EXIT_FAILURE);
                break;
        }

        //Si l'option à un valeur
        if (options[i].value != NULL)
        {
            //Alors cette option ajoute 2 arguments (le nom de l'option et sa valeur)
            nbArguments += 2;

            //On vérifie si une option n'a pas été prise par erreur dans la valeur d'une autre option
            if (strchr(optarg, '-') != NULL)
            {
                printf("Erreur: L'option requiert un argument\n");
                exit(EXIT_FAILURE);
            }
        }
        //Sinon l'option n'a pas de valeur
        else
        {
            //Alors cette option ajoute 1 seul argument (le nom de l'option)
            nbArguments++;
        }
        i++;
    }

    //On vérifie si le nombre d'arguments passés au fichier est égal au nombre normal d'arguments correspondant aux options et leurs valeurs (si existantes
    //On fait -1 sur argc car il compte le nom du fichier en lui même
    if (nbArguments != argc - 1)
    {
        printf("Erreur: L'option ne requiert pas de valeur\n");
        exit(EXIT_FAILURE);
    }

    //On finit le tableau des options par une option vide
    options[i].name = NULL;
    options[i].value = NULL;

    /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                            Création du socket                                   ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */
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

    int temp;
    printf("Port: \n");   //Temp
    scanf("%d", &temp);

    addr.sin_port = htons(temp);
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

    /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                        Écoute et réponse au client                              ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */

    //On initialise les variables
    char buf[512];
    char res[10];
    int N = 0, onContinue = 1, ilResteDesOptions = 1;

    //Fonction read() et write() 
    //Tant que le client ne nous envoie pas "STOP\r"
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
            i = 0;
            ilResteDesOptions = 1;
            while (ilResteDesOptions)
            {
                //Si on est pas encore arrivé à l'option vide qui signe la fin du tableau
                if (options[i].name != NULL)
                {
                    //On vide la string res
                    memset(res, 0, sizeof(res));
                    strcat(res, "Option ");
                    strcat(res, options[i].name);
                    
                    //Si l'option a un valeur, on l'affiche
                    if (options[i].value != NULL)
                    {
                        strcat(res, ": ");
                        strcat(res, options[i].value);
                    }
                    else
                    {
                        strcat(res, " reconnue");
                    }
                    strcat(res, "\n");

                    //On envoie la réponse
                    write(cnx, res, strlen(res));
                }
                else
                {
                    ilResteDesOptions = 0;
                }
                i++;
            }
        }
        else if (strncmp(buf, "STOP\r", strlen("STOP\r")) == 0)
        {
            onContinue = 0;
        }
    }

    return EXIT_SUCCESS;
}