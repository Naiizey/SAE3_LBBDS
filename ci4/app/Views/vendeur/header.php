<!DOCTYPE html>
<html lang=fr>
    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-PCVRSM3');</script>
        <!-- End Google Tag Manager -->
        
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
            <?php if ($controller != "Accueil" && $controller != "Produit"): ?>
                margin-top : 5em;
            <?php else : ?>
                margin-top : 8.4em;
            <?php endif; ?>
            <?php if ($controller == "Panier" || $controller == "Panier (Vide)") : ?>
                padding : 2em;
            <?php endif; ?>
            }

            @media screen and (max-width: 991px){
                main{
                    top: 0;
                    margin-top: 5em;
                }
            }
        </style>
        <title><?= "Alizon - " . $controller ?></title>
    </head>
    <script>
        const base_url = "<?= base_url() ?>";
    </script>
    <body class="bodyVendeur">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCVRSM3"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <header>
            <div class="divHeaderAlizon divHeaderVendeur">
                <a class="lienAlizon" href="<?= base_url() ?>/vendeur/import"> <!-- Lien accueil -->
                    <?php include(dirname(__DIR__,3)."/public/images/header/logo.svg")?>
                    <h1>Alizon</h1>
                </a>
                <form class="formRecherche" action="<?= base_url() ?>/catalogue/">
                    <input class="champsRecherche" type="search" name="search" placeholder="Recherche.." value="<?= ((isset($_GET["search"])) ? $_GET["search"] : '') ?>"/>
                    <label>
                        <input type="submit"><?= file_get_contents(dirname(__DIR__, 3) ."/public/images/header/loupe.svg") ?>
                    </label>
                </form>
                <div class="divPanierProfil divPanierProfilVendeur">
                    <a class="lienConnexion" href="<?= ((session()->has("numero")) ? base_url()."/profil" : base_url()."/connexion") ?>">
                    <?php if (session()->has("numero")) {
                        include(dirname(__DIR__,3)."/public/images/header/profilCon.svg");
                    } else {
                        include(dirname(__DIR__,3)."/public/images/header/profil.svg");
                    } ?>
                    </a>
                    <?php if (session()->has("numero")): ?>
                        <div class="divHoverConnexion divConnected">
                            <p class="pNom">Bonjour <?= (session()->get("nom")) ?></p>
                            <a href="<?= base_url()."/profil"?>"><p>Mon profil</p></a>
                            <a href="<?= base_url()."/commandes"?>"><p>Mes commandes</p></a>
                            <a href="<?= base_url()."/admin/destroy"?>"><p>Se déconnecter</p></a>
                        </div>
                    <?php else: ?>
                        <div class="divHoverConnexion divNotConnected">
                            <a href="<?= base_url()."/connexion"?>"><p>Se connecter</p></a>
                            <a href="<?= base_url()."/inscription"?>"><p>S'inscrire</p></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (isset($GLOBALS['validation'])): ?>
                <?= $GLOBALS['validation']; ?>
            <?php endif; ?>
            <?php if (isset($GLOBALS['invalidation'])): ?>
                <?= $GLOBALS['invalidation']; ?>
            <?php endif; ?>
        </header>