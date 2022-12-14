# Logistic Business Binded to Delivery Protocol -- LBBDP/1.0

Context :  
Nous devions trouver un moyen de tester notre suivi de livraison et de prouver son fontionnement auprès des clients, saus qu'il n'y ai l'éxistence d'une quelconque application côté livreurs.Il sera testé uniquement par un simulateur qui simulera la progression de la livraison. 

Inspiration:
Le protocole prend son inpiration d'une communication avec une API Rest avec l'utilsation de requêtes avec un méthode pour indiquer si on veut lire ou ajouter tel ou tel ressource et avec possibilité de spécifier des options. 


## 1.   Introduction

### 1.1 Le but

Ce protocole de niveau application nécessite une communication internet.
L'objectif de ce protocole est de pouvoir faire communiqué le livreur et son client(Un site marchand, e-commerce, etc...). Au vu de la précision de notre besoin et le fait que l'ambtion n'est pas de créer un protocole qui serait vraiment utilisé, le protocole sera décris est précis et laisse peut de marge de main d'oeuvre pour pouvoir s'adapter à d'autre besoin.


### 1.2 Terminologie

**Serveur** ou **Service** : le logiciel qui attend et traite les requêtes.  

**Client destinaire** : le site e-commerce, site marchand, etc...  

**Client** : connecte au serveur. Il s’agit du logiciel utilisé par le client destinataire pour interroger le service. Ne pas confondre avec le client destinataire.   

**Grammaire** :   la syntaxe décrivant comment doivent/peuvent être formatées les
requêtes du protocole.  

**Requête** : une action faite sur le serveur par le biais d’un client en utilisant le protocole.  

### 1.3 Résumé opérations

Le principe se base sur du requête - réponse avec accusé de récéption dans certains cas.
Les requêtes contiennes chacunes une demande, des options et la version LBBDP tandis que les réponses contiennent, en plus.








