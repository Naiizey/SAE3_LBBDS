<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require("header.php"); ?>
        <main class="mainAccueil">
            <div id="carousel-container">
                <div id="carousel">
                    <ul id="carousel-elem"> <!-- Menu ./images -->
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art (1).jpg" alt="article 1" title="Article 1">
                        </a>
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art (2).jpg" alt="article 2" title="Article 2">
                        </a>
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art (3).jpg" alt="article 3" title="Article 3">
                        </a>
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art (3).jpg" alt="article 3" title="Article 3">
                        </a>
                    </ul>
                </div>
                <img src="<?=base_url()?>/images/fleche_gauche.png" alt="flèche gauche" class="btn btn-prev">
                <img src="<?=base_url()?>/images/fleche_droite.png" alt="flèche droite" class="btn btn-suiv">
            </div>
            <div>
                <section>
                    <div class="titreAccueil">
                        <h1>&Agrave; propos de nous</h1>
                        <hr>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </section>
                <section class="produitsPhare">
                    <div class="titreAccueil">
                        <h1>Nos produits phares</h1>
                        <hr>
                    </div>
                    <div class="articlesAcceuil">
                        <?php $minProd=0; $maxProd=6?>
                        <?php for($i=$minProd;$i<$maxProd && $i<sizeof($prods);++$i): ?>
                            <?= $cardProduit->display($prods[$i])?>
                        <?php endfor; ?>
                    </div>
                    <h2><a href="<?=base_url()?>/catalogue/">Voir les produits</a></h2>
                </section>
                <section>
                    <div class="titreAccueil">
                        <h1>Nos promotions</h1>
                        <hr>
                    </div>
                    <div class="articlesAcceuil">
                        <?php for($i=$minProd;$i<$maxProd && $i<sizeof($prods);++$i): ?>
                            <?= $cardProduit->display($prods[$i])?>
                        <?php endfor; ?>
                    </div>
                    <h2><a href="">Voir les promotions</a></h2>
                </section>
                <div class="iconesAccueil">
                    <figure>
                        <img src="./images/header/" alt="" title="">
                        <figcaption>Livraison gratuite !</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/header/" alt="" title="">
                        <figcaption>Produits issus de commerces Bretons !</figcaption>
                    </figure>
                    <figure>
                        <img src="./images/header/" alt="" title="">
                        <figcaption>Livraison à domicile !</figcaption>
                    </figure>
                </div>
            </div>
        </main>
<?php require("footer.php"); ?>