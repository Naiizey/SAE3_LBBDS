<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <title>Page d'accueil</title>
        <script src="./script.js"></script>
    </head>
    <body>
        <header>
            <div>
                <a class="Alizon" href="index.php"> <!-- Lien accueil -->
                    <img src="./images/logo.png" alt="logoAlizon" title="Accueil" class="logoAlizon">
                    <h1>Alizon</h1>
                </a>
                <div class="divRecherche">
                    <input class="champsRecherche" type="text" name="recherche" placeholder="Recherche.."> 
                    <a href="">
                        <img class="logoLoupe" src="./images/loupe.png" alt="recherche" title="Rechercher">
                    </a>
                </div>
                <div class="divPanierProfil">
                    <a href=""> <!-- Lien panier -->
                        <h2>Panier</h2>
                    </a>
                    <a href="connexion.php"> <!-- Lien profil -->
                        <img class="logoProfil" src="./images/profil.png" onmouseover=passageDeLaSouris(this); onmouseout=departDeLaSouris(this); />
                    </a>
                </div>
            </div>
            <hr>