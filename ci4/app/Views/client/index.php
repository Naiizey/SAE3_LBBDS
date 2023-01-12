<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require __DIR__ . "/../header.php"; ?>
        
        <main class="mainAccueil">

            <div id="carousel-container">
                <div id="carousel">
                    <ul id="carousel-elem"> <!-- Menu ./images -->
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art1.webp" alt="article 1" title="Article 1">
                        </a>
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art2.webp" alt="article 2" title="Article 2">
                        </a>
                        <a href="" class="slide">
                            <img src="<?=base_url()?>/images/art3.webp" alt="article 3" title="Article 3">
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
                    <div class="articlesAccueilPC">
                        <?php $minProdPC=0; $maxProdPC=5?>
                        <?php for($i=$minProdPC;$i<$maxProdPC && $i<sizeof($prods);++$i): ?>
                            <?= $cardProduit->display($prods[$i]) ?>
                        <?php endfor; ?>
                    </div>
                    <div class="articlesAccueilMobile">
                        <?php $minProdMobile=0; $maxProdMobile=4?>
                        <?php for($i=$minProdMobile;$i<$maxProdMobile && $i<sizeof($prods);++$i): ?>
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
                    <div class="articlesAccueilPC">
                        <?php for($i = $minProdPC; $i < $maxProdPC && $i < sizeof($prods); ++$i): ?>
                            <?= $cardProduit->display($prods[$i])?>
                        <?php endfor; ?>
                    </div>
                    <div class="articlesAccueilMobile">
                        <?php for($i=$minProdMobile;$i<$maxProdMobile && $i<sizeof($prods);++$i): ?>
                            <?= $cardProduit->display($prods[$i]) ?>
                        <?php endfor; ?>
                    </div>
                    <h2><a href="" class="seeMoreBtn">Voir les promotions</a></h2>
                </section>
                <div class="iconesAccueil">
                    <figure>
                        <?= file_get_contents(dirname(__DIR__, 3)."/public/images/header/logo.svg") ?>
                        <figcaption>Livraison gratuite !</figcaption>
                    </figure>
                    <figure>
                        <?= file_get_contents(dirname(__DIR__, 3)."/public/images/header/hermine.svg") ?>
                        <figcaption>Produits issus de commerces Bretons !</figcaption>
                    </figure>
                    <figure>
                        <?= file_get_contents(dirname(__DIR__, 3)."/public/images/header/carton.svg") ?>
                        <figcaption>Livraison à domicile !</figcaption>
                    </figure>
                </div>
            </div>
        </main>
<?php require __DIR__ . "/../footer.php"; ?>
<script>
    carrousel();
</script>