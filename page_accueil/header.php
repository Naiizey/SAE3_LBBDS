<!DOCTYPE html>
<html lang=fr>
    <head>
        <?php
            $logo = file_get_contents("images/header/logo.svg");
            $profil = file_get_contents("images/header/profil.svg");
            //$carton = file_get_contents("images/header/carton.svg");
            //$argentBlanc = file_get_contents("images/header/argentBlanc.svg");

            if ($_SERVER['SCRIPT_NAME'] == "/panier.php" | $_SERVER['SCRIPT_NAME'] == "/panierVide.php")
            {
                $newDivHeader = '<div class="divHeaderPanier">
                                    <div class="divSuivie divSuivie1">
                                        '.$logo.'
                                        <h3>1. Panier</h3>
                                    </div>
                                    <div class="divSeparationSuivie "></div>
                                    <div class="divSuivie divSuivie2">
                                        '.$profil.'
                                        <h3>2. Identification</h3>
                                    </div>
                                    <div class="divSeparationSuivie"></div>
                                    /*<div class="divSuivie divSuivie3">
                                        '.$carton.'
                                        <h3>3. Livraison</h3>
                                    </div>
                                    <div class="divSeparationSuivie"></div>
                                    <div class="divSuivie divSuivie4">
                                        '.$argentBlanc.'
                                        <h3>4. Paiement</h3>
                                    </div>*/
                                </div>';
            } 
            else
            {
                $loupe = file_get_contents("images/header/loupe.svg");
                $newDivHeader = "<div class='divRecherche'>
                                    <input class='champsRecherche' type='text' name='recherche' placeholder='Recherche..'>
                                    <a href=''>".$loupe."</a>
                                </div>";
            }
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Page d'accueil</title>
    </head>
    <body>
        <header>
            <div class="divHeaderAlizon">
                <a class="lienAlizon" href="index.php"> <!-- Lien accueil -->
                    <?php include("./images/header/logo.svg")?>
                    <h1>Alizon</h1>
                </a>
                <?php echo $newDivHeader ?>
                <div class="divPanierProfil">
                    <a href="panier.php"> <!-- Lien panier -->
                        <h2>Panier</h2>
                    </a>
                    <a class="lienConnexion" href="connexion.php">
                        <?php include("./images/header/profil.svg")?>
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