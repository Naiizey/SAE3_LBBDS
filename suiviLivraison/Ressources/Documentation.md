# Simulateur de livraison basé sur le protocole LBBDP/1.0

## I. Installation

Pour obtenir l'exécutable du simulateur il vous suffit d'exécuter la commande `make` dans le répertoire Simulateur_LBBDP

Pour qu'il soit exécutable depuis n'importe quel répertoire et ajouté la documentation man, il faut exécuter la commande `make install`

## II. Exécution

`lbbdp -h` vous décrit les différentes options pouvant être spécifiées.

### Fichier authentification

Nous avons `-f`, qui est une option importante, en effet cette option nous permet d'indiquer un **chemin** vers le fichier qui contiendra l'authentification nécessaire à la connexion du client.

_Par défaut_: `"listeIdentifications.txt"`

À noter que le mot de passe suivant n'est pas hashé

_Exemple de fichier authentification_:
```
id : 153
password : 39715c8f486b05c362dd45fd2872dc03
```

### Capacité de livraison

L'option `-c` permet de spécifier une limite de commande dans la file.


_Par défaut_: `5`

Le stockage des livraison se fait grâce à une file, il sera impossible de rentrer plus de commandes qu'elle a de capacité de commande.

### Durée de journée

L'option `-j` permet de configurer le temps en secondes que réprésentera une journée pour le simulateur.

_Par défaut_: `7`

En effet, notre programme est simulateur qui va simuler l'acheminement des commandes, la progression dans les différentes étapes de la livraison est mise à jour à chaque actualisation (ACT), cette mise à jour ce fait en fonction du temps passé dans la file de notre simulateur et de combien de secondes représente un journér pour notre programme. 



## III. Le protocole 

### L'authentification 

_Exemple pour s'authentifier_:
```
AUT LBBDP/1.0
{ 
    "auth": { "id" : "153", 
    "pass" : "39715c8f486b05c362dd45fd2872dc03" } 
} 
;
```

À noter si une erreue `50` et renvoyé par le simulateur c'est sûrement dû au fait que le fichier contenant les authentification est introuvable. Voir l'utilisation du `-f`.

_Exemple d'envoi livraison_:
```
NEW LBBDP/1.0
{ 
    "livraisons" : [ 
    { 
        "identifiant" : "4", 
        "time" : 0,
        "etat" : "En charge"
    }, 
    { 
        "identifiant" : "2", 
        "time" : 0, 
        "etat" : "En charge"
    } 
    , 
    { 
        "identifiant" : "19", 
        "nombre" : 5, 
        "time" : 0
    } 
    
    ] 
} 
;
```

_Exemple de demande d'actualisation_:
```
ACT LBBDP/1.0
;
```
_Exemple de réponse pour accusé de réception_:
```
REP LBBDP/1.0
{ 
    "livraisons" : [ 
    { 
        "identifiant" : "4"
    }, 
    { 
        "identifiant" : "2"
    } 
    , 
    { 
        "identifiant" : "19"
    } 
    
    ] 
}
;
```  

### IV : Source

### cJSON
Le système de parsing et de serialisation de JSON 
provient d'un code conçu par DaveGamble avec la contributions d'autres personnes

**License**: https://github.com/DaveGamble/cJSON/blob/master/LICENSE

**Github**: https://github.com/DaveGamble/cJSON
