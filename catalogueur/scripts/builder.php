<!DOCTYPE html>
<html lang=fr>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <style>
            @font-face {
                font-family: "Expletus Sans";
                src: url("dependances/fonts/ExpletusSans-Bold.ttf") format("truetype")
            }

            @font-face {
                font-family: "Montserrat-Medium";
                src: url("dependances/fonts/Montserrat-Medium.ttf") format("truetype");
            }

            @font-face {
                font-family: "Montserrat-Regular";
                src: url("dependances/fonts/Montserrat-Regular.ttf") format("truetype");
            }

            @font-face {
                font-family: "Montserrat-Bold";
                src: url("dependances/fonts/Montserrat-Bold.ttf") format("truetype");
            }

            @media print {
                .pagebreak { 
                    page-break-before: always; 
                } 

                .divUnProduit {
                    break-inside: avoid;
                }

                body {
                    -webkit-print-color-adjust: exact;
                }
            }

            <?php include("modele/modele.css") ?>
        </style>
        <?php
            $json = json_decode(file_get_contents("samples/mono.json"), true);
            $break = true;
            $entreprises = $json["entreprises"];
        ?>
    </head>
    <body>
        <header>
            <a class="lienAlizon" href=""> <!-- Lien accueil -->
                <?php include("dependances/images/header/logo.svg")?>
                <h1>Alizon</h1>
            </a>
        </header>
        <main>
            <?php foreach ($entreprises as $glossaire): ?>
                <section class="sectionPresentation <?= (!$break) ? "pagebreak" : "" ?>">
                    <?php $break = false; ?>
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
                <?php foreach ($glossaire["articles"] as $article): ?>
                    <div class="divUnProduit">
                        <img src="<?= $article['lienImage']; ?>">
                        <div class="divNomDescription">
                            <h2><?= $article['intitule']; ?></h2>
                            <p><?= $article['description_prod']; ?></p>
                        </div>
                        <div class="divPrix">
                            <p><?= $article['prixTtc']; ?>€ TTC</p>
                        </div>
                    </div>
                    <hr>
                <?php endforeach;?>
                </section>
            <?php endforeach;?>
        </main>
    </body>
</html>