# Catalogueur

## Introduction

Le rôle du catalogueur Alizon est de transformer les données exportées du site du format json au format pdf. 

Ces données contiennent un vendeur ou une liste de vendeur ainsi que les produits sélectionnés sur le site parmi ceux qu'ils vendent.
Sur le site web cette sélection est appelée "quidi".

## Dépendances

Le fonctionnement du catalogueur dépend grandement de son arborescence notamment :
- Du dossier **dependances/** qui contient les polices d'écritures et les images (nous avons fait le choix de les remettre ici pour que ce soit plus facile de l'utiliser indépendamment du site si nécessaire)   
- De l'existence de fichiers comme **builder.php**, **mono.json**, **modele.css**...
- D'internet pour récupérer les outils de conversion
- De l'outil Docker

## Utilisation

Accédez à un terminal de commandes et naviguez dans le dossier scripts/ 
puis exécutez le script shell **go** avec la commande :
```console
./go
```

## Fonctionnement

Le script shell go que vous allez exécuter fait appel à deux outils conteneurisés grâce l'outil Docker à partir de 2 images disponibles sur le dépôt officiel : Docker Hub.

Ce script va récupérer ces images, et exécuter des instances de celles ci pour utiliser les outils de conversion, respectivement :
- Un premier outil qui va exécuter builder.php à partir du fichier json précisé en option (-f ou --file) et enregistrer le résultat dans modele/modele.html
- Et un deuxième qui va convertir modele/modele.html en catalogue.pdf, le résultat final

