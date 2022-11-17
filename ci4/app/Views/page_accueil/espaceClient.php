<?php require("header.php"); ?>
<main class="mainEspaceCli">
    <?php echo file_get_contents(dirname(__DIR__,3)."/public/images/header/profil.svg");?>
    <div class="espCliContent">
        <h2>Profil</h2>
        <div class="nameMdp">
            <h3 class="name">Bonjour <?php echo $pseudo?></h3>
            <section class="mdpModif">
                <button href="">Modifier son mot de passe</button>
            </section>
        </div>
        <div class="infos">
            <div class="left">
                <section class="cliNomPrenom">
                    <div class="cliNom">
                        <h4>Nom : <?php echo $surname?></h4>
                        <button href="">Modifier</button>
                    </div>
                    <div class="cliPrenom">
                        <h4>Prénom : <?php echo $firstname?></h4>
                        <button href="">Modifier</button>
                    </div>
                </section>
                <section class="mail">
                    <h4>Adresses mail :</h4>
                    <ul>
                        <?php $email?>
                    </ul>
                </section>
            </div>
            <div class="right">
                <section class="facturation">
                    <h4>Adresses de facturation :</h4>
                    <ul>
                        <?php
                        $adressesFacture = $adresseFact;
                        foreach($adressesFacture as $adresse){
                            echo '<li>'.$adresse.'</li>';
                        }
                        ?>
                    </ul>
                </section>
                <section class="livraison">
                    <h4>Adresses de livraison :</h4>
                    <ul>
                    <?php
                        $adressesLivraison = $adresseLivr;
                        foreach($adressesLivraison as $adresse){
                            echo '<li>'.$adresse.'</li>';
                        }
                        ?>
                    </ul>
                </section>
            </div>
        </div>
</main>
<?php require("footer.php"); ?>