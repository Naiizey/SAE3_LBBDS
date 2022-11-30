<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require("header.php"); ?>
        <?= ((isset($validation)) ? $validation : ""); ?>
        <main class="mainAccueil">
            <div id="carousel-container">
                <div id="carousel">
                    <ul id="carousel-elem"> <!-- Menu ./images -->
                        <a href="" class="slide">
                            <img src="<?= base_url() ?>/images/art (1).jpg" alt="article 1" title="Article 1">
                        </a>
                        <a href="" class="slide">
                            <img src="<?= base_url() ?>/images/art (2).jpg" alt="article 2" title="Article 2">
                        </a>
                        <a href="" class="slide">
                            <img src="<?= base_url() ?>/images/art (3).jpg" alt="article 3" title="Article 3">
                        </a>
                        <a href="" class="slide">
                            <img src="<?= base_url() ?>/images/art (3).jpg" alt="article 3" title="Article 3">
                        </a>
                    </ul>
                </div>
                <img src="<?= base_url() ?>/images/fleche_gauche.png" alt="flèche gauche" class="btn btn-prev">
                <img src="<?= base_url() ?>/images/fleche_droite.png" alt="flèche droite" class="btn btn-suiv">
            </div>
          
            <div>
                <section class="produitsPhare">
                    <div class="titreAccueil">
                        <h1>Nos produits phares</h1>
                        <hr>
                    </div>
                    <div class="articlesAcceuil">
                        <?php $minProd=0; $maxProd=6?>
                        <?php for($i=$minProd;$i<$maxProd && $i<sizeof($prods);++$i): ?>
                            <?= $cardProduit->display($prods[$i]) ?>
                        <?php endfor; ?>
                    </div>
                    <h2><a href="<?= base_url() ?>/catalogue/" class="seeMoreBtn">Voir les produits</a></h2>
                </section>
                <section>
                    <div class="titreAccueil">
                        <h1>Nos promotions</h1>
                        <hr>
                    </div>
                    <div class="articlesAcceuil">
                        <?php for($i = $minProd; $i < $maxProd && $i < sizeof($prods); ++$i): ?>
                            <?= $cardProduit->display($prods[$i])?>
                        <?php endfor; ?>
                    </div>
                    <h2><a href="" class="seeMoreBtn">Voir les promotions</a></h2>
                </section>
                <div class="iconesAccueil">
                    <figure>
                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/logo.svg") ?>
                        <figcaption>Livraison gratuite !</figcaption>
                    </figure>
                    <figure>
                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/hermine.svg") ?>
                        <figcaption>Produits issus de commerces Bretons !</figcaption>
                    </figure>
                    <figure>
                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/header/carton.svg") ?>
                        <figcaption>Livraison à domicile !</figcaption>
                    </figure>
                </div>
            </div>
        </main>
<?php require("footer.php"); ?>
<script>
    carrousel();
</script>