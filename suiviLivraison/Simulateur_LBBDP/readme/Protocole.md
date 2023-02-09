# Logistic Buisness Binded to Delivery Protocol -- LBBDP/1.0

> ### Contexte :  
Nous devions trouver un moyen de tester notre suivi de livraison et de prouver son fonctionnement auprès des clients, sans créer une application côté livreur. Il sera testé uniquement par un simulateur qui simulera la progression de la livraison. 

Inspiration:
Le protocole est inspiré d'une communication avec une API Rest grâce à l'utilisation de requêtes. Notre protocole est doté d'une méthode pour indiquer si on veut lire ou ajouter telle ou telle ressource, avec la possibilité de spécifier des options. 


## 1.   Introduction
---

> ### 1.1 Le but 

Ce protocole de niveau application nécessite une communication internet.
L'objectif de ce protocole est de pouvoir faire communiquer le livreur et son client(Un site marchand, e-commerce, etc...). Au vu de la précision de notre besoin et du fait que l'ambition n'est pas de créer un protocole qui sera vraiment utilisé, notre protocole ne sera pas adapté à d'autres besoins que le nôtre.


> ### 1.2 Terminologie

**Serveur** ou **Service** : le logiciel qui attend et traite les requêtes.  

**Client destinataire** : le site e-commerce, site marchand, etc...  

**Client** : se connecte au serveur. Il s’agit du logiciel utilisé par le client destinataire pour interroger le service. Ne pas confondre avec le client destinataire.   

**Grammaire** :   la syntaxe décrivant comment doivent/peuvent être formatées les
requêtes du protocole.  

**Opération** : une action faite sur le serveur par le biais d’un client en utilisant le protocole.  

**Contenu**: Contient les information nécessaires pour effectuer l'opération, dans le cas d'une réponse ce sont les données demandées par une opération.
Le contenu suit l'en-tête d'opération.

>### 1.3 Fonctionnement globales

Le principe se base sur une opération - réponse avec accusé de réception dans certains cas.

Les opérations contiennent chacune une demande, la version LBBDP et un contenu en format JSON. Les réponses sont de la même forme avec en plus, un code de réponse à la place d'une opération.

> ### 1.4 En-tête d'opération

Chaque réquête est formulé de cette façon:
`OPT LBBDP/1.0\r\n`

où OPT est le nom de l'opération.

Les différentes opérations sont définies dans (2: opérations)

> ### 1.5 En tête de réponse
`CODE LBBDP/1.0\r\n`

où CODE correspond au code réponse.  
Les différents codes sont définis dans la section (3: Réponses)

> ### 1.6 Le contenu

Le format du contenu est en JSON, ainsi le contenu débute après l'introduction d'un premier caractère du type '{' juste après le retour à la ligne de l'en-tête. Il est bien entendu refermé par un '}'.


Pour ce qui est du format présenté entre ces accolades ('{' et '}'): il faut se conformer à l'habituel format json:
https://www.json.org/json-fr.html 

**;** pour la fin d'un contenu séparé d'un retour CRLF entre lui et le **json**.



## 2. Opérations
---
> ### 2.1 AUT : Authentification

Cette opération permet de s'authentifier auprès du serveur, nous serons à partir de là reconnu à partir de notre adresse IP.
Les opérations déclencheront l'authentification dans le cas où ne sommes pas encore authentifié. Si le contenu ne possède pas les champs nécessaires à l'authentification, nous serons  refusés. 

> ### 2.2 NEW : Prise en charge d'une commande

Cette opération permet de prendre en charge une commande. 
Pour cela il faut indiquer dans le contenu et dans une clé d'array ou attribut d'objet "numéro commande" avec comme valeur le numéro de la commande.

Ainsi, dans le contenu il sera demandé de renseigner 2 propriétés:
- id
- pass

>### 2.3 ACT : Actualisation des commandes 

Cette opération permet de récupérer les états de toutes les commandes qui sont prises en charges.

> ### 2.4 REP: Accusé de réception
Pour que le serveur puisse se débarrasser des commandes arrivées à destination, le client doit renvoyer un accusé contenant ces commandes. Ainsi les places dans la liste pourront être libérées.

## 3. Réponses
---

Soit la requête a été prise en compte :
> ### 3.1 Réussite
- 00(Réussite):
    - 01(Exécution) : Envoie simplement la réponse attendue, afin de confirmer la requête
    - 02 (En attente) : Attente d'un accusé de réception de certaines données

Autrement, La requête n'a pas été prise ne compte pour une certaine raison:

> ### 3.1 Erreur format
- 10 (Erreur format):
    - 11(Opération inconnue) :  l'opération n'a pas été reconnue.
    - 12(Complément non nécessaire) : complément inutile.
    - 13(Complément inconnue) : complément non reconnu pour l'opération

> ### 3.1 Erreur authentification
- 20 (Authentification):
    - 21(Authentification manquante) : il faut s'identifier pour avoir la permission d'exécuter cette opération.
    - 22(Authentification erronée) : L'identification est erronée
> ### 3.1 Erreur logique
- 30(Erreur logique) 
    - 31(File pleine): la prise en charge n'est plus possible, il faut attendre que des places soient libérées.

> ### 3.1 Erreur contenu
- 40 (Erreur format contenu)
    - 41(Erreur format JSON): le contenu ne correspond pas aux normes JSON.
    - 42(Erreur contenu JSON): les propriétés renseignées ne correspondent pas à celles demandées.
- 50 (Erreur interne)

## 4. Détails des contenus
---


> ### 4.1 définition de type de contenus

Dans les prochaines présentations de contenus (4.2) nous allons utiliser des formats spécifiques, que nous définissons ici

**4.1.1 objet commande**  
Représentation de `<"commande">`, objet qui a ce format en JSON:
```json

    {
        "identifiant" : <"nombre">,   
        "time" : <"nombre">,
        "etat" : <"enum">
    }

```
L'identifiant est obligatoire.  
L'état et time sont optionnels   

**4.1.2 enum**

Représentation de `<"enum">`, qui est une chaîne de caractère parmi cette énumération: 

* "regional"
* "en charge"
* "local"
* "destinataire"



> ### 4.2 Les contenu de protocole acceptable
Ces contenus sont positionnés dans un objet root (les premières et dernières accolades "{}", entre autre), ces différents contenus peuvent être séparés par des accolades.

**4.2.1 La commande unique**
```json
{  
    "livraison" : <"commande">
}  
```
i
`<"commande">`: voir 4.1.1: objet commande 
`<"enum">` : voir 4.1.2: enum
**4.2.2 liste de commandes**
```json
{
    "livraisons" : [
        <"commande">,  
        <"commande">,  
        <"commande"> 
    ]
     
}  
```
`<"commande">`: voir 4.1: objet commande

**4.2.3 Une authentification**
```json
{  
    "auth":  
    {  
        "id" : <"chaine">,  
        "pass" : <"chaine">  
    }  
}  
```