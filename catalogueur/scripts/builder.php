<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" type="text/css" href="/modele/modele.css" />
        <style>
            @font-face {
                font-family: "Expletus Sans";
                src: url("/docker/dependances/fonts/ExpletusSans-Bold.ttf") format("truetype")
            }

            @font-face {
                font-family: "Montserrat-Medium";
                src: url("/docker/dependances/fonts/Montserrat-Medium.ttf") format("truetype");
            }

            @font-face {
                font-family: "Montserrat-Regular";
                src: url("/docker/dependances/fonts/Montserrat-Regular.ttf") format("truetype");
            }

            @font-face {
                font-family: "Montserrat-Bold";
                src: url("/docker/dependances/fonts/Montserrat-Bold.ttf") format("truetype");
            }
        </style>
        <?php
            $json = json_decode(file_get_contents("../samples/mono.json"), true);

            //print_r($json[0]["id"]);
        ?>
    </head>
    <body>
        <header>
            <a class="lienAlizon" href=""> <!-- Lien accueil -->
                <?php include("../docker/dependances/images/header/logo.svg")?>
                <h1>Alizon</h1>
            </a>
        </header>
        <main>
            <section class="sectionPresentation">
                <div class="divVendeur">
                    <img src="<?= $glossaire['logo']; ?>" alt="Profil">
                    <div class="divNomNote">
                        <h2><?= $glossaire['pseudo']; ?></h2>
                        <?php if (false): ?>
                            <div class="noteAvis"><?= $cardProduit->notationEtoile($glossaire['note_vendeur']) ?></div>
                        <?php endif; ?>
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
            <?php foreach ($json as $article): ?>
                <div class="divUnProduit">
                    <img src="<?= $article['lien_image']; ?>">
                    <div class="divNomDescription">
                        <h2><?= $article['intitule_prod']; ?></h2>
                        <p><?= $article['description_prod']; ?></p>
                    </div>
                    <div class="divPrix">
                        <p><?= $article['prix_ht']; ?>€ HT</p>
                        <p><?= $article['prix_ttc']; ?>€ TTC</p>
                    </div>
                </div>
                <hr>
            <?php endforeach;?>
            </section>
        </main>
    </body>
</html>