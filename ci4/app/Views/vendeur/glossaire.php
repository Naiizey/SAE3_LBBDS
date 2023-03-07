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
                    <img src="https://imageio.forbes.com/specials-images/imageserve/5ed6636cdd5d320006caf841/The-Blackout-Tuesday-movement-is-causing-Instagram-feeds-to-turn-black-/960x0.jpg?format=jpg&width=960" alt="Profil">
                    <div class="divNomNote">
                        <h2>Guy Cotten</h2>
                        <div class="noteAvis"><?= $cardProduit->notationEtoile(4) ?></div>
                    </div>
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
                            <td>guy.cotten@alizon.net</td>
                        </tr>
                    </tbody>
                </table> 
                <h2 class="h2Presentation">Présentation</h2>
                <!-- <p>Je suis un sociétée <del>très vertueuse</del> et <del>je suis neutre en carbone depuis 1899</del>, en effet on <del>ne</del> peut <del>pas</del> me critiquer car <del>je</del> ne pratique <del>pas</del> l’évasion fiscale. De plus je <del>ne</del> vire <del>jamais</del> des employés alors que je me porte bien économiquement.</p> -->
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut dolores non eum ea accusamus cupiditate voluptates quis sapiente architecto tempora? Debitis sequi dolor iure fugiat voluptas. Accusamus eius reiciendis sapiente!</p>
            </section>   
            <section class="sectionProduits">
                <div class="divUnProduit">
                    <img src="https://img.cuisineaz.com/660x660/2015/01/29/i113699-photo-de-crepe-facile.webp" alt="Produit">
                    <div class="divNomDescription">
                        <h2>Crêpes</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, ea incidunt? Distinctio nulla placeat itaque sint non reiciendis, aperiam, minima debitis libero velit minus maiores quae officia ex.</p>
                    </div>
                    <div class="divPrix">
                        <p>80€ HT</p>
                        <p>90€ TTC</p>
                    </div>
                </div>
                <hr>
                <div class="divUnProduit">
                    <img src="https://img.cuisineaz.com/660x660/2015/01/29/i113699-photo-de-crepe-facile.webp" alt="Produit">
                    <div class="divNomDescription">
                        <h2>Crêpes</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur, ea incidunt? Distinctio nulla placeat itaque sint non reiciendis, aperiam, minima debitis libero velit minus maiores quae officia ex.</p>
                    </div>
                    <div class="divPrix">
                        <p>80€ HT</p>
                        <p>90€ TTC</p>
                    </div>
                </div>
            </section>
        </main>
    </body>
</html>