<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
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
                        <img class="logoProfil" src="./images/header/profil.png" onmouseover=passageDeLaSouris(this); onmouseout=departDeLaSouris(this); />
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