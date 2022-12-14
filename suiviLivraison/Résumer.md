 
https://www.rfc-editor.org/rfc/rfc1945.html

# Paramètres à l'exécutions
* La capacité de livraison
* La durée d’un jour
* Chemin fichier liste identification
* Un help
 

# But de protocole 




* Prise en charge : récupération du colis et commencer livraison 
Échec [File pleine]: indique que la prise en charge n’est plus possible  
Échec [Authentification]: indique que les identifiants ne sont pas valables  
Échec [Logiciel] : indique un message d’erreur lié à l’erreur  

* Actualisation : renvoie la liste des livraisons (possibilité de filtrer un état)  
Réussite: renvoie la liste des livraisons, filtré, demande d’accusé de réception si la liste de livraisons inclut les livraison terminée   
->Accusé de réception des livraison terminées  
Échec [Filtre] : indique que le filtre n’est pas reconnue  
Échec [Accusé de réception] : indique que l’accusé n’est pas valide ( le bâtard )  

* Étapes de livraison :
Prise en charge : instantanée
Transport vers la plateforme régionale : aléatoire, entre 1 et 3 jours
Transport entre la plateforme et le site local de livraison : 1 jour
Livraison au destinataire : instantanée, ce qui libère la place dans la file
Accusé de réception de clôture de cycle : instantané

Commande perdue | Jours de retard
Parsing into JSON
