<?php require("header.php"); ?>
        <main class="mainPanier">
            <div class="divPanierEtAside">
                <section class="sectionPanier">
                    <div class="divPanierHeader">
                        <h2>Votre panier est vide</h2>
                    </div>
                    <hr>
                    <div>
                        <h3 class="h3PasArticlePanier">Vous n’avez aucun article dans votre panier. <br> <a href="index.php" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>
                        <?php
                            $connecte=true;
                            if ($connecte==false)
                            {
                                echo "<h3 class='h3PasArticlePanier'>Connectez-vous pour récupérer votre panier.</h3>";
                                echo "<a href=connexion.php class='lienPanier'>Se connecter</a>";
                            }
                        ?>
                    </div>
                </section>
                <aside>
                    <h2>Sous-total (0 article) : 00,00€</h2>
                    <a href="" class="lienPanierVide">Valider le panier</a>
                </aside>
            </div>
            <section class="sectionRecommandationsPanier">
                <h2>Recommandations</h2>
                <hr>
                <ul>
                    <li>
                        <a href="">
                            <img src="./images/art1.png" alt="article 1" title="Article 1">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="./images/art2.png" alt="article 2" title="Article 2">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="./images/art3.png" alt="article 3" title="Article 3">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="./images/art4.png" alt="article 4" title="Article 4">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="./images/art5.png" alt="article 5" title="Article 5">
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <img src="./images/art5.png" alt="article 6" title="Article 6">
                        </a>
                    </li>
                </ul>
            </section>
        </main>
<?php require("footer.php"); ?>