<!DOCTYPE html>
<html>
    <head>
        <?php 
            if ($_SERVER['SCRIPT_NAME'] == "/panier.php")
            {
                $newDivHeader = '';
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
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Page d'accueil</title>
        <script src="./script.js"></script>
    </head>
    <body>
        <header>
            <div class="divHeaderAlizon">
                <a class="lienAlizon" href="index.php"> <!-- Lien accueil -->
                    <img src="./images/header/logo.png" alt="logoAlizon" title="Accueil" class="logoAlizon">
                    <h1>Alizon</h1>
                </a>
                <?php echo $newDivHeader; ?>
                <div class="divPanierProfil">
                    <a href="panier.php"> <!-- Lien panier -->
                        <h2>Panier</h2>
                    </a>
                    <a class="lienConnexion" href="connexion.php">
                        <img class="logoProfil" src="./images/header/profil.png" onmouseover=passageDeLaSouris(this); onmouseout=departDeLaSouris(this); />
                    </a>
                </div>
            </div>