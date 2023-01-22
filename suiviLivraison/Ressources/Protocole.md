# Logistic Business Binded to Delivery Protocol -- LBBDP/1.0

Context :  
Nous devions trouver un moyen de tester notre suivi de livraison et de prouver son fontionnement auprès des clients, saus qu'il n'y ai l'éxistence d'une quelconque application côté livreurs.Il sera testé uniquement par un simulateur qui simulera la progression de la livraison. 

Inspiration:
Le protocole prend son inpiration d'une communication avec une API Rest avec l'utilsation de requêtes avec un méthode pour indiquer si on veut lire ou ajouter tel ou tel ressource et avec possibilité de spécifier des options. 


## 1.   Introduction
---

### 1.1 Le but

Ce protocole de niveau application nécessite une communication internet.
L'objectif de ce protocole est de pouvoir faire communiquer le livreur et son client(Un site marchand, e-commerce, etc...). Au vu de la précision de notre besoin et le fait que l'ambtion n'est pas de créer un protocole qui serait vraiment utilisé, le protocole sera décris est précis et laisse peut de marge de main d'oeuvre pour pouvoir s'adapter à d'autre besoin.


### 1.2 Terminologie

**Serveur** ou **Service** : le logiciel qui attend et traite les requêtes.  

**Client destinaire** : le site e-commerce, site marchand, etc...  

**Client** : connecte au serveur. Il s’agit du logiciel utilisé par le client destinataire pour interroger le service. Ne pas confondre avec le client destinataire.   

**Grammaire** :   la syntaxe décrivant comment doivent/peuvent être formatées les
requêtes du protocole.  

**Requête** : une action faite sur le serveur par le biais d’un client en utilisant le protocole.  

### 1.3 Opérations globales

Le principe se base sur du requête - réponse avec accusé de récéption dans certains cas.
Les requêtes contiennes chacunes une demande, des options et la version LBBDP tandis que les réponses contiennent, en plus un contenu formaté en JSON.

### 1.4 En-tête des requêtes

Chaque réquête est formulé de cette façon:
`OPT LBBDP/1.0\r\n`

où OPT est le nom de l'opérations,  
compléments les informations supplémentaires à formulé selon les opérations.

### 1.5 En tête des répones
`OPT LBBDP/1.0\r\n`

où OPT est le nom de l'opérations, 
et le CODE correspond au code réponse.

### 1.6 Le contenu

Le format du contenu est en JSON, ainsi le contenu débute après l'introduction d'un premier caractère du type '{' juste après le retour à la ligne de l'en-tête.Il est bien entendu refermer par un '}'.


Pour ce qui est du format présenté entre ces accolades ('{' et '}'): il faut se conformer à l'habituel format json:
https://www.json.org/json-fr.html 

**;** pour la fin d'un contenu séparé d'un retour CRLF entre lui et le **json**.



## 2. Requêtes
---
### 2.1 AUT : Authentification

Cette opération permet de s'authentifier auprès du serveur, nous serons à partir de là reconnu à partir de notre addresse IP.
Les opération déclencherons celle-ci dans le cas où ne sommes pas encore authentifié. Si le contenu ne poosède pas les champs nécessaires à l'authentification,nous somme refusés.

### 2.2 NEW : Prise en charge d'une commande

Cette opération permet de faire prendre en charge une commande. 
Pour cela il faut indiquer dans le contenu et dans une clé d'array ou attribut d'objet "numéro commande" avec comme valeur le numéro de la commande.

Ainsi, dans le contenu il demandandé de renseigné 2 propriété:
- id
- pass

### 2.3 ACT : Actualisation des commandes 

Cette opération permet de récupérer les états de toutes les commandes qui sont prises en charges. On peut filtrer en indiquent les états que l'ont veut récupérer.
Pour cela il faut indiquer une des compléments ci-dessous:  
- tout: récupérer toute commande
- nouvelle: Les commandes qui ont été prise en charge
- regional : Les commandes en plateforme régionale
- locale : Les commmandes en plateforme locale
- destinataire : Les commandes arrivées au client
- perdu : La commande a été perdue

### 2.4 REP: Accusé de réception
Pour que le serveur puisse se débarrasser des commandes arriver à destination, le client doit renvoyer un accusé contenant ces commandes. Ainsi les places dans la liste pourront être libérés.

## 3. Réponses

Soit la requête a été prise en compte :
- 00(Réusite):
    - 01(Execution) : Envoie simplement la réponse attendue, afin de confirmé la requête
    - 02 (En attente) : Attente d'un accusé de réception de certaines données

Autrement, La requête n'a pas été prise ne compte pour un certaine raison:
- 10 (Erreur format):
    - 11(Opération inconnue) :  l'opération n'a pas été reconnue.
    - 12(Complément non nécessaire) : compléments indiqué mais est inutile.
    - 13(Complément inconnue) : compléments non reconnnue pour l'opération

- 20 (Authentification):
    - 21(Authentification manquante) : il faut s'identifié pour avoir la permission d'éxecuté cette opération.
    - 22(Authentification erronée) : L'identification est erronée

- 30(Erreur logique) 
    - 31(File pleine): la prise en charge n'est plus possible, il faut attendre que des places soient libérés.

- 40 (Erreur format contenu)
    - 41(Erreur format JSON): le contenu ne correspond pas aux normes JSON.
    - 42(Erreur contenu JSON): les propriétes ne sont pas celles qui ont été demandés.
- 50 (Erreur interne)

## 4. Détails des contenus
---




### 4.1 Une commande unique
```json
{  
    "livraison" : {
        "identifiant" : <"nombre">,   
        "time" : <"nombre">,
        "etat" : <"enum">
    }
}  
```
identifiant est obligatoire.
L'etat et time sont optionnels
`<"commande">`: voir 4.1: objet commande 
`<"enum">` :"regional", "en charge", "local", "destinataire"

### 4.3 liste de commandes
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

### 4.4 Une authentification
```json
{  
    "auth":  
    {  
        "id" : <"chaine">,  
        "pass" : <"chaine">  
    }  
}  
```












