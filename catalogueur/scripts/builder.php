<?php 
    #On récupère l'option -f ou --file pour récupérer le nom du fichier json (on affiche un message d'erreur si l'option n'est pas renseignée)
    $options = getopt("f:", ["file:"]);

    if (!isset($options["f"]) && !isset($options["file"])) 
    {
        echo "Veuillez renseigner le nom du fichier json à traiter avec l'option -f ou --file";
        exit;
    }

    #On récupère le nom du fichier json
    $file = (isset($options["f"])) ? $options["f"] : $options["file"];

    #On vérifie que le fichier json existe
    if (!file_exists($file)) 
    {
        throw new Exception("Le fichier json n'existe pas\n");
        exit;
    }
?>
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
            #On récupère les données du fichier json
            $json = json_decode(file_get_contents($file), true);
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
            <?php foreach ($entreprises as $entreprise): ?>
                <!-- Si c'est le premier vendeur de la page on ne break pas à la page suivante -->
                <section class="sectionPresentation <?= (!$break) ? "pagebreak" : "" ?>"> 
                    <?php $break = false; ?>
                    <div class="divVendeur">
                        <img src="<?= $entreprise['logo']; ?>" alt="Profil">
                        <div class="divNomNote">
                            <h2><?= $entreprise['pseudo']; ?></h2>
                            <?php if (false): ?>
                                <div class="noteAvis"><?= $cardProduit->notationEtoile($entreprise['note_vendeur']) ?></div>
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
                                <td><?= $entreprise['siret']; ?></td> 
                            </tr>
                            <tr>
                                <th>TVA Intracommunautaire :</th>
                                <td><?= $entreprise['tvaInter']; ?></td>
                            </tr>
                            <tr>
                                <th>Adresse :</th>
                                <td><?= $entreprise['numero_rue']." ".$entreprise['nom_rue']."<br>".$entreprise['code_postal']." ".$entreprise['ville']; ?></td>
                            </tr>
                            <tr>
                                <th>Contact :</th>
                                <td><?= $entreprise['email']; ?></td>
                            </tr>
                        </tbody>
                    </table> 
                    <h2 class="h2Presentation">Présentation</h2>
                    <p><?= $entreprise['texte_presentation']; ?></p>
                </section>   
                <section class="sectionProduits">
                <?php foreach ($entreprise["articles"] as $article): ?>
                    <div class="divUnProduit">
                        <img src="<?= $article['lienimage']; ?>">
                        <div class="divNomDescription">
                            <h2><?= $article['intitule']; ?></h2>
                            <p><?= $article['description_prod']; ?></p>
                        </div>
                        <div class="divPrix">
                            <p><?= $article['prixttc']; ?>€ TTC</p>
                        </div>
                    </div>
                    <hr>
                <?php endforeach;?>
                </section>
            <?php endforeach;?>
        </main>
    </body>
</html>