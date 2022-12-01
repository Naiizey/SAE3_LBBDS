<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/style.css" />
        <link rel="icon" href="<?=base_url()?>/public/images/header/logo.svg" type="image/svg">
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

            :root {
                --slide-count: 3;
            }
            
            main {
            <?php if ($controller != "index" && $controller != "produit"): ?>
                margin-top : 5em;
            <?php else : ?>
                margin-top : 8.4em;
            <?php endif; ?>
            <?php if ($controller == "panier" || $controller == "panierVide") : ?>
                padding : 2em;
            <?php endif; ?>
            }
        </style>
        <title><?= $controller ?></title>
    </head>
    <script>
        const base_url = "<?= base_url() ?>";
    </script>
    <body>
        <header>
            <div class="divHeaderAlizon">
                <a class="lienAlizon" href="<?= base_url() ?>/index"> <!-- Lien accueil -->
                    <?php include(dirname(__DIR__,3)."/public/images/header/logo.svg")?>
                    <h1>Alizon</h1>
                </a>
                <?php if ($controller == "panier" || $controller == "panierVide" || $controller == "compte_redirection" || $controller == "infoLivraison" || $controller == "paiement"): ?>
                    <div class="divSuivi">
                        <div class="<?= (($controller == "panier" )?"etat-courant-commande":"") ?>">
                            <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/panier.svg") ?>
                            <h3>Panier</h3>
                        </div>
                        <hr>
                        <div class="<?= (($controller == "compte_redirection" )?"etat-courant-commande":"") ?>">
                            <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/profil.svg") ?>
                            <h3>Identification</h3>
                        </div>
                        <hr>
                        <div class="<?= (($controller == "infoLivraison" )?"etat-courant-commande":"") ?>">
                            <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/carton.svg") ?>
                            <h3>Livraison</h3>
                        </div>
                        <hr>
                        <div class="<?= (($controller == "paiement" )?"etat-courant-commande":"") ?>">
                            <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/paiement.svg") ?>
                            <h3>Paiement</h3>
                        </div>
                    </div>
                <?php else: ?>
                    <form class="formRecherche" action="<?= base_url() ?>/catalogue/">
                        <input required class="champsRecherche" type="search" name="search" placeholder="Recherche.." value="<?= ((isset($_GET["search"])) ? $_GET["search"] : '') ?>"/>
                        <label>
                            <input type="submit"><?= file_get_contents(dirname(__DIR__,3) ."/public/images/header/loupe.svg") ?>
                        </label>
                    </form>
                <?php endif; ?>
                <div class="divPanierProfil">
                    <a class="lienHPanier" href="<?= base_url() ?>/panier">
                        <?php echo file_get_contents(dirname(__DIR__,3)."/public/images/header/panier.svg"); ?>
                        <?php if ($GLOBALS["quant"] != 0): ?>
                            <span class="quantPanier"><?= $GLOBALS["quant"] ?></span>
                        <?php elseif ($GLOBALS["quant"] > 9): ?>
                            <span class="quantPanier">+9</span>
                        <?php endif; ?>
                    </a>
                    <a class="lienConnexion" href="<?= ((session()->has("numero")) ? base_url()."/espaceClient" : base_url()."/connexion") ?>">
                        <?php include(dirname(__DIR__,3)."/public/images/header/profil.svg")?>
                    </a>
                </div>
            </div>
            <?php if ($controller == "index" || $controller == "produit"): ?>
                <nav>
                    <hr>
                    <ul>
                        <li class="liCategorie">
                            <a class="categorie" href="<?= base_url() ?>/">Catégorie 1</a>
                        </li>
                        <li class="liCategorie">
                            <a class="categorie" href="<?= base_url() ?>/">Catégorie 2</a>
                        </li>
                        <li class="liCategorie">
                            <a class="categorie" href="<?= base_url() ?>/">Catégorie 3</a>
                        </li>
                        <li class="liCategorie">
                            <a class="categorie" href="<?= base_url() ?>/">Catégorie 4</a>
                        </li>
                        <li class="liCategorie">
                            <a class="categorie" href="<?= base_url() ?>/">Catégorie 5</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </header>