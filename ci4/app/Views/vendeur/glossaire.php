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
                    <img src="<?= $glossaire['logo']; ?>" alt="Profil">
                    <div class="divNomNote">
                        <h2><?= $glossaire['pseudo']; ?></h2>
                        <div class="noteAvis"><?= $cardProduit->notationEtoile($glossaire['note_vendeur']) ?></div>
                    </div>
                </div>
                <table>
                    <tbody>
                        <tr>
                            <th>Raison sociale :</th>
                            <td>SA</td>
                            <!-- manque ça -->
                        </tr>
                        <tr>
                            <th>SIRET :</th>
                            <td><?= $glossaire['numero_siret']; ?></td> 
                        </tr>
                        <tr>
                            <th>TVA Intracommunautaire :</th>
                            <td><?= $glossaire['tva_intercommunautaire']; ?></td>
                        </tr>
                        <tr>
                            <th>Adresse :</th>
                            <td><?= $glossaire['numero_rue']." ".$glossaire['nom_rue']."<br>".$glossaire['code_postal']." ".$glossaire['ville']; ?></td>
                        </tr>
                        <tr>
                            <th>Contact :</th>
                            <td><?= $glossaire['email']; ?></td>
                        </tr>
                    </tbody>
                </table> 
                <h2 class="h2Presentation">Présentation</h2>
                <p><?= $glossaire['texte_presentation']; ?></p>
            </section>   
            <section class="sectionProduits">
                <!-- manque ça -->
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