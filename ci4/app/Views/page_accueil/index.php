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
                        <?php echo file_get_contents(dirname(__DIR__,3)."/public/images/header/logo.svg")?>
                        <figcaption>Livraison gratuite !</figcaption>
                    </figure>
                    <figure>
                        <?php echo file_get_contents(dirname(__DIR__,3)."/public/images/header/hermine.svg")?>
                        <figcaption>Produits issus de commerces Bretons !</figcaption>
                    </figure>
                    <figure>
                        <?php echo file_get_contents(dirname(__DIR__,3)."/public/images/header/carton.svg")?>
                        <figcaption>Livraison à domicile !</figcaption>
                    </figure>
                </div>
            </div>
            <div class="mentionLegales">
                <h2>Conditions générales d’utilisation</h2>
                <p>Bienvenue sur Alizon.bzh.</p>
                <p>Alizon vous offre la possibilité de visualiser et rechercher dans un catalogue de produits proposé par l’association de marchands de la COBREC, qui sont les propriétaires du site. En tant que client de la COBREC vous pouvez en plus, acheter des produits et vous les faire livrer et facturer aux adresses que vous avez spécifiées.</p>
                <p>Vous pouvez aussi commenter et laisser une note sur les produits que vous avez utilisés.</p>
                <p>Pour ce qui est du vendeur appartenant à la COP de la COBREC, il a la possibilité de poster ses produits, les mettre en réductions, de les mettre en avant et aussi visualiser les stocks de chaque produit.</p>
                <p>En utilisant la plateforme, vous reconnaissez avoir lu, compris et accepté l’entièreté et sans aucunes réserves les conditions générales d’utilisation et de ventes présentées ci-dessous.</p>
            </div>
        </main>
<?php require("footer.php"); ?>