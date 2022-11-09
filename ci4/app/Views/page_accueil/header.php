<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/style.css" />
        <style>
            @font-face {
                font-family: "Expletus Sans";
                src: url("<?=base_url() ?>/fonts/ExpletusSans-Bold.ttf") format("truetype")
            }

            @font-face {
                font-family: "Montserrat-Medium";
                src: url("<?=base_url() ?>/fonts/Montserrat-Medium.ttf") format("truetype");
            }

            @font-face {
                font-family: "Montserrat-Regular";
                src: url("<?=base_url() ?>/fonts/Montserrat-Regular.ttf") format("truetype");
            }

            @font-face {
                font-family: "Montserrat-Bold";
                src: url("<?=base_url() ?>/fonts/Montserrat-Bold.ttf") format("truetype");
            }
        </style>
        <title>Page d'accueil</title>
    </head>
    <body>
        <header>
            <div class="divHeaderAlizon">
                <a class="lienAlizon" href="<?= base_url() ?>/index"> <!-- Lien accueil -->
                    <?php include(dirname(__DIR__,3)."/public/images/header/logo.svg")?>
                    <h1>Alizon</h1>
                </a>
                <?php 
                    if ($controller == "panier" || $controller == "panierVide")
                    {
                        echo   '<div class="divSuivi">
                                    <div>
                                        '.file_get_contents(dirname(__DIR__,3)."/public/images/header/panier.svg").'
                                        <h3>1. Panier</h3>
                                    </div>
                                    <hr>
                                    <div>
                                        '.file_get_contents(dirname(__DIR__,3)."/public/images/header/profil.svg").'
                                        <h3>2. Identification</h3>
                                    </div>
                                    <hr>
                                    <div>
                                        '.file_get_contents(dirname(__DIR__,3)."/public/images/header/logo.svg").'
                                        <h3>3. Livraison</h3>
                                    </div>
                                    <hr>
                                    <div>
                                        '.file_get_contents(dirname(__DIR__,3)."/public/images/header/paiement.svg").'
                                        <h3>4. Paiement</h3>
                                    </div>
                                </div>';
                    } 
                    else 
                    {
                        echo   '<div class="divRecherche">
                                <input class="champsRecherche" type="text" name="recherche" placeholder="Recherche..">
                                <a href="">'.file_get_contents(dirname(__DIR__,3)."/public/images/header/loupe.svg").'</a>
                                </div>';
                    }
                ?>
                <div class="divPanierProfil">
                    <a href="<?= base_url() ?>/panier"> 
                        <h2>Panier</h2>
                    </a>
                    <a class="lienConnexion" href="<?= base_url() ?>/connexion">
                        <?php include(dirname(__DIR__,3)."/public/images/header/profil.svg")?>
                    </a>
                </div>
            </div> 
            <?php 
                if ($controller == "index" || $controller == "produit")
                {
                    echo    '<nav>
                                <hr>
                                <ul>
                                    <li class="liCategorie">
                                        <a class="categorie" href="' . base_url() . '/">Catégorie 1</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="' . base_url() . '/">Catégorie 2</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="' . base_url() . '/">Catégorie 3</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="' . base_url() . '/">Catégorie 4</a>
                                    </li>
                                    <li class="liCategorie">
                                        <a class="categorie" href="' . base_url() . '/">Catégorie 5</a>
                                    </li>
                                </ul>
                            </nav>';
                }  
            ?>
        </header>