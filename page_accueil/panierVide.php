<?php require("header.php"); ?>
        </header>
        <main class="mainPanier">
            <section class="sectionPanier sectionPanierVide">
                <div class="divPanierHeader">
                    <h2>Votre panier est vide</h2>
                </div>
                <hr>
                <h3 class="h3PasArticlePanier">Vous n’avez aucun article dans votre panier. <br> <a href="index.php" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>
                <?php
                    $connecte=false;
                    if ($connecte==false){
                        echo "<h3 class='h3PasArticlePanier'>Connectez-vous pour récupérer votre panier.</h3>";
                        echo "<a href=connexion.php class='lienPanier lienConnexionPanier'>Se connecter</a>";
                    }
                ?>
            </section>
            <aside>
                <h2>Sous-total (0 article) : 00,00€</h2>
                <a href="" class="lienPanierVide">Valider le panier</a>
            </aside>
            <section class="sectionRecommandationsPanier">
                <h2>Recommandations</h2>
                <hr>
                <div class="divRecommandationsPanier">
                    <a href="">
                        <img src="./images/art1.png" alt="article 1" title="Article 1">
                    </a>
                    <a href="">
                        <img src="./images/art2.png" alt="article 2" title="Article 2">
                    </a>
                    <a href="">
                        <img src="./images/art3.png" alt="article 3" title="Article 3">
                    </a>
                    <a href="">
                        <img src="./images/art4.png" alt="article 4" title="Article 4">
                    </a>
                    <a href="">
                        <img src="./images/art5.png" alt="article 5" title="Article 5">
                    </a>
                    <a href="">
                        <img src="./images/art1.png" alt="article 6" title="Article 5">
                    </a>
                </div>
            </section>
        </main>
<?php require("footer.php"); ?>