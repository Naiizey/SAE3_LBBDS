# Simulateur de livraison basé sur le protocole LBBDP/1.0

## I. Installation

Pour obtenir l'éxecutable du simulateur il vous suffit d'éxécuter la commande `make` dans le repertoire Simulateur_LBBDP

Pour qu'il soit éxecutable depuis n'importe quel répertoire et ajouté la documentation man, il faut exécuté la commande `make install`

## II. Exécution

`lbbdp -h` vous décris les différentes options pouvant être spécifié.

### Fichier authentification

Nous avons `-f`, qui est une option importante, en effet cette option nous permet d'indiquer un **chemin** vers le fichier qui contiendra l'authentification nécessaire à la connexion du client.

_Exemple de fichier authentification_:
```
id : 153
password : 39715c8f486b05c362dd45fd2872dc03
```



### 
