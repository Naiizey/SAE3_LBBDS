<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/glossaire.css" />
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
        <?php echo link_tag("images/logo.png", 'shortcut icon', 'image/png'); ?>
    </head>
    <body>
        <header>
            <a class="lienAlizon" href="<?= base_url() ?>/index"> <!-- Lien accueil -->
                <?php include(dirname(__DIR__,3)."/public/images/header/logo.svg")?>
                <h1>Alizon</h1>
            </a>
        </header>
        <main>
            <section class="sectionPresentation">
                <div class="divVendeur">
                    <img src="imageProfil" alt="">

                </div>
                <table>
                    <tbody>
                        <tr>
                            <th>Raison sociale :</th>
                            <td>SA</td>
                        </tr>
                        <tr>
                            <th>SIRET :</th>
                            <td>ZAUKDGG23L</td>
                        </tr>
                        <tr>
                            <th>TVA Intracommunautaire :</th>
                            <td>5679424949</td>
                        </tr>
                        <tr>
                            <th>Adresse :</th>
                            <td>1 rue de la Renaissance <br> 22300 Lannion</td>
                        </tr>
                        <tr>
                            <th>Contact :</th>
                            <td>Jaimearnaquer@alizon.net</td>
                        </tr>
                    </tbody>
                </table> 
                <h2>Présentation</h2>
                <p>Je suis un sociétée <del>très vertueuse</del> et <del>je suis neutre en carbone depuis 1899</del>, en effet on <del>ne</del> peut <del>pas</del> me critiquer car <del>je</del> ne pratique <del>pas</del> l’évasion fiscale. De plus je <del>ne</del> vire <del>jamais</del> des employés alors que je me porte bien économiquement.</p>
            </section>   


        </main>
    </body>
</html>