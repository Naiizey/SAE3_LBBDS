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
            
            <?php include("modele/modele.css") ?>
        </style>
        <?php
            $json = json_decode(file_get_contents("samples/mono.json"), true);

            $glossaire = array(
                "id_quidi" => 1,
                "num_compte" => 5,
                "intitule_prod" => "Cola x6",
                "prix_ht" => 5,
                "prix_ttc" => 6,
                "description_prod" => "Nouvelle boisson bretonne au cola, issue de d'une agrigulture bio éthique, bio responsable, bio consciente.",
                "logo" => "https://webstockreview.net/images/sample-png-images-8.png",
                "note_vendeur" => 3,
                "pseudo" => "COBREC_1",
                "numero_siret" => 123456789,
                "tva_intercommunautaire" => "FR50123456789",
                "texte_presentation" => "Bonjour, nous sommes la COBREC",
                "moyenne_note_prod" => 4.5,
                "email" => "cobrec1@alizon.net",
                "numero_rue" => 3,
                "nom_rue" => "rue de la guerre",
                "code_postal" => 70000,
                "lien_image" => "https://images.pexels.com/photos/8879617/pexels-photo-8879617.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                "num_image" => 0,
                "ville" => "lille"
            );
            
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
        </main>
    </body>
</html>