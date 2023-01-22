#include <stdio.h>
#include <stdlib.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <openssl/md5.h>
#include <fcntl.h>
#include <errno.h>
#include <string.h>
#include <unistd.h>
#include <getopt.h>

#include "lbbdp.h"
#include "fifo.h"
#include "user.h"
#include "json.h"




#define MAX_OPTIONS 10
#define OPTIONS "hc:j:f:"
#define OPTION_DEFAUT_1 NULL                        //Option aide (help) -h 
#define OPTION_DEFAUT_2 "5"                         //Option pour renseigner la capacité de livraison
#define OPTION_DEFAUT_3 "7"                         //Option pour renseigner une durée de jour personnalisée (en minutes)
#define OPTION_DEFAUT_4 "listeIdentifications.txt"  //Option pour renseigner le chemin d'un fichier de liste d'identification

struct Option
{
    int given;
    char *name;
    char *value;
};

int indice_array_user;
int max_array_user;
arrayUser array_user=NULL;

typedef struct Option lst_option[MAX_OPTIONS];
 //On créé un tableau de structures pour stocker les options
//Renseigner ici le nombre maximum d'options




int trouveIdOption(char name, lst_option options);
int collectOptions(int argc, char *argv[], lst_option options);
void config(int *  capaLivraison,int *dureeJour,char * fichier,lst_option options);
int gestConnect(int cnx, struct sockaddr adrClient, File * listeCommande,char * pathToFilec);
cJSON * getJson(char * buf,int cnx);
int verifConnect(cJSON * js, struct sockaddr addr, char * pathToFile, user * client);

int main(int argc, char *argv[])
{
    lst_option options;
    collectOptions(argc,argv,options);
    int maxCapaciteLivraison;
    int time_day_sec;
    char path[255];
    config(&maxCapaciteLivraison, &time_day_sec, path, options);
    File listeCommande;
    initialisationFile(&listeCommande, time_day_sec, &maxCapaciteLivraison);
    
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
    else
    {
        printf("En attente du client (telnet localhost %d)\n", temp);
    }

    //Fonction accept() - Serveur seulement
    int size;
    int cnx;
    struct sockaddr conn_addr;
    size = sizeof(conn_addr);
    cnx = accept(sock, (struct sockaddr *)&conn_addr, (socklen_t *)&size);
    if (cnx == -1)
    {
        perror("Connexion échouée");
    }
    else
    {
        printf("Connexion établie, en attente d'instructions\n");
    }

    /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                        Écoute et réponse au client                              ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */

    gestConnect(cnx, conn_addr,&listeCommande,path );

    return EXIT_SUCCESS;
}

int collectOptions(int argc, char *argv[], lst_option options){

    
    /*
    ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
    ┃                                   Options                                       ┃
    ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
    */

   
    
    char optionList[MAX_OPTIONS*2], optionListSP[MAX_OPTIONS*2]; //Fois deux parce que ya les :
    strcpy(optionList, OPTIONS);
    strcpy(optionListSP, OPTIONS);

    //On retire les : de la chaîne de caractères afin d'obtenir la liste des options possibles
    int i = 0;
    while(i < strlen(optionListSP))
    {
        if (optionListSP[i] == ':') 
        { 
            for (int j = i; j < strlen(optionListSP); j++)
            {
                optionListSP[j] = optionListSP[j + 1];   
            }
        }
        else
        {
            i++;
        }
    }

    //On créé un tableau de structures en définissant toutes les options possibles avec la liste des options sans les :
    for (i = 0; i < strlen(optionListSP); i++)
    {
        options[i].given = 0;
        options[i].name = malloc(2);
        options[i].name[0] = optionListSP[i];
        options[i].name[1] = '\0';
    }

    //On renseigne les valeurs par défaut des options
    options[0].value = OPTION_DEFAUT_1;             
    options[1].value = OPTION_DEFAUT_2;             
    options[2].value = OPTION_DEFAUT_3;             
    options[3].value = OPTION_DEFAUT_4;             

    //On finit le tableau des options par une option vide
    options[i].given = 0;
    options[i].name = NULL;
    options[i].value = NULL;

    //Tant qu'il y a des options à lire
    //L'argument de la fonction getopt() "ab:c:d:e:" correspond aux différentes options disponibles 
    //Les : sont comme des slicers en python, ils signifient que suite à l'option il faut renseigner une valeur (ou attribut lié à l'option)
    //Exemple : ./simulateur -a -b <valeur> -c <valeur> -d <valeur> -e <valeur>
    //À noter que l'option a n'a pas de valeur car il n'y a pas de : à sa suite dans l'argument de la fonction getopt()
    //Le mot est récupéré dans la variable optarg et n'est pas utilisable si l'option n'a pas de valeur
    int idOption, opt, nbArguments = 0;
    while ((opt = getopt(argc, argv, optionList)) != -1)
    {
        switch (opt)
        {
            case 'h':
                //Option aide (help) -h 
                idOption = trouveIdOption('h', options);
                options[idOption].given = 1;
                //On laisse options[idOption].value car l'options aide n'a pas de valeur
                break;
            case 'c':
                //Option pour renseigner la capacité de livraison
                idOption = trouveIdOption('c', options);
                options[idOption].given = 1;
                options[idOption].value = optarg; 
                break;
            case 'j':
                //Option pour renseigner une durée de jour personnalisée
                idOption = trouveIdOption('j', options);
                options[idOption].given = 1;
                options[idOption].value = optarg;
                break;
            case 'f':
                //Option pour renseigner le chemin d'un fichier de liste d'identification
                idOption = trouveIdOption('f', options);
                options[idOption].given = 1;
                options[idOption].value = optarg;
                break;
            default:
                //On laisse getopt gérer les erreurs dans ce cas
                exit(EXIT_FAILURE);
                break;
        }

        //Si l'option à un valeur
        if (options[idOption].value != NULL)
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

    //Si il n'y a aucune option renseignée, on en informe le programme en mettant le nom de l'option à NULL
    //Lorsque l'on parcourra le tableau d'options, on pourra ainsi savoir si il y a des options ou non
    if (nbArguments == 0)
    {
        options[0].name = NULL;
    }

    return EXIT_SUCCESS;
}

int trouveIdOption(char name, lst_option options)
{
    int i = 0;
    while (options[i].name != NULL)
    {
        if (*(options[i].name) == name)
        {
            return i;
        }
        i++;
    }
    return -1;
}


void config(int * capaLivraison,int * dureeJour,char * fichier,lst_option options){
    (*capaLivraison)=atoi(options[1].value);
    (*dureeJour)=atoi(options[2].value);
    printf("%d",*dureeJour);
    strcpy(fichier,options[3].value);
}



int testConnect(lst_option options, int cnx){
    //On initialise les variables
    char buf[512];
    char res[10];
    int N = 0, onContinue = 1;
    //int size;
 

    //Fonction read() et write() 
    //Tant que le client ne nous envoie pas "STOP\r"
    while (onContinue)
    {
        /*size = */read(cnx, buf, 512);
        if (strncmp(buf, "AVANCE\r", strlen("AVANCE\r")) == 0)
        {
            N++;
            
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
            int i = 0;
            int ilResteDesOptions = 1;
            while (ilResteDesOptions)
            {
                //Si on est pas encore arrivé à l'option vide qui signe la fin du tableau
                if (options[i].name != NULL)
                {
                    //Si l'option a été donnée
                    if (options[i].given)
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
                }
                else
                {
                    ilResteDesOptions = 0;
                    if (i == 0)
                    {
                        write(cnx, "Aucune option n'a été reconnue\n", strlen("Aucune option n'a été reconnue\n"));
                    }
                }
                i++;
            }
        }
        else if (strncmp(buf, "STOP\r", strlen("STOP\r")) == 0)
        {
            onContinue = 0;
        }
        else
        {
            write(cnx, "Commande inconnue\n", strlen("Commande inconnue\n"));
        }
    }

    return 0;
    
}

/**
 * @brief Gestion de la connexion avec un client, qui permet de récupérer les commndes et de les honorer ou non
 * 
 * @param cnx socket, ici il permet de lire le contenu de la demande du client  
 * @param adrClient permet d'accéder à l'ip du client
 * @param listeCommande liste des commandes
 * @param pathToFile chemin vers le fichier des authentifiants
 * @return int 
 */
int gestConnect(int cnx, struct sockaddr adrClient, File * listeCommande, char * pathToFile){
    char buf[512];
    char * entreeBuf;
    char res[20];
    int onContinue=1;
    int retour;
    while(onContinue){
        retour=ERR_PROTOC;
        printf("buf:\n%s\n",buf);
        memset(buf,0,512);
        printf(buf);
        read(cnx, buf, 512);
        entreeBuf=strstr(buf,"LBBDP/1.0\r\n");
        if(entreeBuf!=NULL)
        {
            
            if(strncmp(buf, "AUT ", 4)==0){
                printf("Authentification...\n");
                retour=handleAUT(getJson(entreeBuf,cnx), adrClient, pathToFile);
            }else if(strncmp(buf, "NEW ", 4)==0){
                user * client=NULL;          
                printf("Prise en charge de commande...\n");
                retour=handleNEW(getJson(entreeBuf,cnx), listeCommande, client, adrClient, pathToFile);
            }else if(strncmp(buf, "ACT ", 4)==0){
                printf("Actualisation commmande...\n");
                user * client=NULL;
                retour=verifConnect(getJson(entreeBuf,cnx), adrClient, pathToFile, client);
                if(retour>=0)
                    retour=handleACT(listeCommande,cnx);
            }else if(strncmp(buf, "REP ", 4)==0){
                user * client=NULL;
                printf("Accusé de réception...\n");
                retour=handleREP(getJson(entreeBuf,cnx), listeCommande,adrClient, pathToFile, client);
            }else{
                retour=-11;
                printf("Commande non reconnue\n");
            }
            
        }
        else
        {
            retour=ERR_PROTOC_OPERINCONUE;
        }


        if(retour < 0)//Erreurs
        {
            snprintf(res,20,"%d\r\n",-retour);
        }
        else//Réussite
        {
            snprintf(res,20,"0%d\r\n",retour);
        }

        write(cnx, res,20);
        
    }
       

    return retour;

}

/**
 * @brief Get the Json object
 * 
 * @param buf le buffer récupérer de la lecture précédente
 * @param cnx socket, ici il permet de lire le contenu de la demande du client  
 * @return cJSON* 
 */
cJSON * getJson(char * buf, int cnx){
   
    char buffer[1024];
    cJSON * retour=NULL;
    long unsigned int maxLongStr=1024;
    long unsigned int actualLongStr=0;
    char * str_json=malloc(maxLongStr * sizeof(char));
    strcpy(str_json,"");
    
    
    if(buf!=NULL){
        if(strlen(buf)>12){
            strcpy(buffer,buf+12);
        }else{
            strcpy(buffer,"\0");
        }
        printf("Json ?\n");
        while(strchr(buffer,';')==NULL){
            char * n=strchr(buffer,'\n');
         
            //nettoyage du \r
            if(n!=NULL && *(n-1)=='\r'){
                (*(n-1))='\n';
                (*(n))=' ';
            }
            
            strcat(str_json, buffer);
            actualLongStr=strlen(buffer);
            if(maxLongStr<actualLongStr){
                maxLongStr=maxLongStr+1024;
                str_json=realloc(str_json,(maxLongStr) * sizeof(char));
                 
            }
            printf("JSON %ld:%s\n",strlen(str_json),str_json);
            
            
            memset(buffer,0,1024);
           
            read(cnx,buffer,1024);
            printf("BUF: %s\n",buffer);
           
        }
        
        strcat(str_json, buffer);
        printf("fin\n");
        cJSON_Parse(str_json);
        printf("JSON:\n%s\n",cJSON_Print(retour));
        retour=cJSON_Parse(str_json);
    }
    else{
        printf("Erreur format...LBBDP/1.0\n");
     
    
    }

    
    return retour;


}

int hereConnection(user * client, struct sockaddr addr, char * pathToMdpFile){
    if(array_user==NULL){
        indice_array_user=0;
        max_array_user=20;
        array_user=init_array_session(max_array_user);

    }
    printf("Poursuite connection...\n");
    return connection(client, addr, array_user, &indice_array_user, &max_array_user , pathToMdpFile);
}

/**
 * @brief Après avoir récupérer les ou la livraison(s), on tente de se connecter et si c'est une réussite on ajoute les commandes 
 * 
 * @param new un json parser via cJSON
 * @param liste liste des commandes
 * @param cli session du client
 * @param addr permet d'accéder à l'ip du client
 * @param pathToFile chemin vers le fichier des authentifiants
 * @return int 
 */
int handleNEW(cJSON * new,File * liste,user * cli, struct sockaddr addr,char * pathToFile ){
    if(new == NULL) return ERR_JSON_NORME;
    int result=verifConnect(new, addr, pathToFile,cli);
    if (result==0)
    {
        printf("??\n");
        result=parcoursPourLivraison(new->child, liste); 
    }

    return result;
    


}
/**
 * @brief Après avoir récupérer les authentifiants, on les utilises pour tenter la connexion ainsi que la création de session.
 * 
 * @param js un json parser via cJSON
 * @param addr information permettant d'accéder à l'ip du client
 * @param pathToFile chemin vers le fichier des authentifiants
 * @return int Code réponse
 */
int handleAUT(cJSON * js, struct sockaddr addr, char * pathToFile){
    if(js == NULL) return ERR_JSON_NORME;
    user cli;
    cli.id=NULL;
    cli.pass=NULL;
    printf("???: %s\n",cJSON_Print(js));
    int result=parcoursPourAuth(js->child,&cli);
   
    if(result==0)
    {
        printf("Connection...\n");
        result=hereConnection(&cli,addr,pathToFile);
        if (result==0)
            printf("%s\n",getIp(cli.addr));
    }

    return result;


}
/**
 * @brief Permet de récupérer la liste des commandes tout en leur mettant à jour leurs états.
 * 
 * @param liste liste des commandes
 * @param cnx chemin vers le fichier pour authentification
 * @return int Code réponse
 */
int handleACT(File * liste, int cnx){
    
    File aEnvoyer;
    initialisationFile(&aEnvoyer, liste->timeDaySec, NULL);
    copieFile(*liste, &aEnvoyer);


    int retour;
    char * pourEnvoyer;

        pourEnvoyer=cJSON_Print(envoiLivraison(&aEnvoyer,NULL));
        retour=(pourEnvoyer!=NULL);
        if(retour){
            printf("RESULT:\n%s\n",pourEnvoyer);
            retour=write(cnx, pourEnvoyer, strlen(pourEnvoyer));
            write(cnx, "\r\n", sizeof("\r\n"));
            if(retour<0){
                retour=ERR_INTERNE;
            }else{
                retour=REUSSITE_ENATT;
            }
        }else{
            retour=ERR_INTERNE;
        }


        return retour;
}

/**
 * @brief Suppression des livraison présentes dans cette accusé et qui sont arrivées à destination 
 * 
 * @param liste 
 * @param recu 
 * @return int Code réponse
 */
int supprimeRecu(File * liste, File recu){
    bool bonnEtat = true;
    for(Element * curr=liste->tete; curr!=NULL && bonnEtat; curr=curr->suivant){
        bonnEtat=checkDestinataire(curr->livraison,liste->timeDaySec);
        if(bonnEtat && trouverId(recu,curr->livraison.identifiant)){
            printf("Element retiré: %d",recu.indice);
            afficherLivraison(*retraitFile(liste));
            (recu.indice)--;
        }
    }

    return REUSSITE_RET;

}

/**
 * @brief Permet de récupérer un accusé de réception et de supprimer les livraison présentes dans cette accusé et qui sont arrivées à destination 
 * 
 * @param rep  un json parser via cJSON
 * @param liste la file de commande
 * @return int Code réponse
 */
int handleREP(cJSON * rep, File * liste, struct sockaddr addr, char * pathToFile, user * client){
    int retour = verifConnect(rep, addr, pathToFile, client);
    if(retour==0)
    {
        printf("Début REP\n");
        if (rep==NULL) 
            return ERR_JSON_NORME;
        File contenueRep;
        initialisationFile(&contenueRep, liste->timeDaySec, NULL);
        printf("Parcours\n");
            retour=parcoursPourLivraison(rep->child, &contenueRep);
        if(retour>=0){
            retour=supprimeRecu(liste, contenueRep);
        }
    }
    
    return retour;
    
}   

int verifConnect(cJSON * js, struct sockaddr addr, char * pathToFile, user * client){
    user * newSession=IPdejaConnecte(array_user, indice_array_user, addr);
    int result;
    if(newSession==NULL)
    {
        result=handleAUT(js, addr, pathToFile);
    }
    else
    {
        result=0;
    }

    return result;
}