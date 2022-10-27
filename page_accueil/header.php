<!DOCTYPE html>
<html lang=fr>
    <head>
<<<<<<< HEAD
        <?php 
            if ($_SERVER['SCRIPT_NAME'] == "/panier.php" || $_SERVER['SCRIPT_NAME'] == "/panierVide.php")
            {
                $newDivHeader = '<div class="divHeaderPanier">
                                    <div class="divSuivie1">
                                        <img class="imgSuivie1" src="./images/header/logo.png" alt="Panier" title="Panier">
                                        <h3 class="h3Suivie">1. Panier</h3>
                                    </div>
                                    <div class="divSeparationSuivie"></div>
                                    <div class="divSuivie2">
                                        <img class="imgSuivie2" src="./images/header/loupe.png" alt="Identification" title="Identification">
                                        <h3 class="h3Suivie">2. Identification</h3>
                                    </div>
                                    <div class="divSeparationSuivie"></div>
                                    <div class="divSuivie3">
                                        <img class="imgSuivie1" src="./images/header/profil.png" alt="Livraison" title="Livraison">
                                        <h3 class="h3Suivie">3. Livraison</h3>
                                    </div>
                                    <div class="divSeparationSuivie"></div>
                                    <div class="divSuivie4">
                                        <img class="imgSuivie1" src="./images/header/logo.png" alt="panier" title="panier">
                                        <h3 class="h3Suivie">4. Paiement</h3>
                                    </div>
                                </div>';
            } 
            else
            {
                $newDivHeader = '<div class="divRecherche">
                                    <input class="champsRecherche" type="text" name="recherche" placeholder="Recherche.."> 
                                    <a href="">
                                        <img class="logoLoupe" src="./images/header/loupe.png" alt="recherche" title="Rechercher">
                                    </a>
                                </div>';
            }    
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="style.css">
=======
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
>>>>>>> 2618ae9ebb99e8add9af99e7ec024fdc587bb978
        <title>Page d'accueil</title>
    </head>
    <body>
        <header>
            <div class="divHeaderAlizon">
                <a class="lienAlizon" href="index.php"> <!-- Lien accueil -->
                    <img src="./images/header/logo.png" alt="logoAlizon" title="Accueil" class="logoAlizon">
                    <h1>Alizon</h1>
                </a>
                <?php 
                    if ($_SERVER['SCRIPT_NAME'] != "/panier.php")
                    {
                        echo   '<div class="divRecherche">
                                    <input class="champsRecherche" type="text" name="recherche" placeholder="Recherche.."> 
                                    <a href="">
                                        <img class="logoLoupe" src="./images/header/loupe.png" alt="recherche" title="Rechercher">
                                    </a>
                                </div>';
                    } 
                ?>
                <div class="divPanierProfil">
                    <a href="panier.php"> <!-- Lien panier -->
                        <h2>Panier</h2>
                    </a>
                    <a class="lienConnexion" href="connexion.php">
                        <img class="logoProfil" src="./images/header/profil.png" title="logo_connexion" alt="logo_connexion" onmouseover=passageDeLaSouris(this); onmouseout=departDeLaSouris(this);>
                    </a>
                </div>
            </div> 
            <?php 
                if ($_SERVER['SCRIPT_NAME'] == "/index.php" || $_SERVER['SCRIPT_NAME'] == "/produit.php")
                {
                    echo    '<nav>
                                <hr>
                                <ul>
                                    <li class="liCategorie">
                                        <a class="categorie" href="">Catégorie 1</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="">Catégorie 2</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="">Catégorie 3</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="">Catégorie 4</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="">Catégorie 5</a>
                                    </li>
                                </ul>
                            </nav>';
                }  
            ?>
        </header>