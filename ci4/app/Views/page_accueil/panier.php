<?php require("header.php"); 
    function afficheErreurs($e, $codeE)
    {
        if (isset($e[$codeE]))
        {
            return "<div class='bloc-erreurs'>
                        <p class='paragraphe-erreur'>$e[$codeE]</p>
                    </div>";
        }   
    } 
    function afficheRetours($r, $codeR)
    {
        if (isset($r[$codeR]))
        {
            return "<div class='bloc-erreurs'>
                        <p class='paragraphe-valid'>$r[$codeR]</p>
                    </div>";
        }   
    }  
?>
        <main class="mainPanier">
            <div>
                <a class="lienAlizonPanier" href="<?= base_url() ?>/index"> <!-- Lien accueil -->
                    <?php include(dirname(__DIR__,3)."/public/images/header/logo.svg")?>
                    <h1>Alizon</h1>
                </a>
            </div>
            <div class="divPanierEtAside">
                <?php if (empty($produits)): ?>
                    <section class="sectionPanier">
                        <div>
                            <div class="divPanierHeader">
                                <h2>Votre panier est vide</h2>
                            </div>
                            <hr>
                            <div>
                                <div class="h3PasArticlePanier">
                                    <h3>Vous n’avez aucun article dans votre panier.</h3>
                                    <h3><a href="<?= base_url() ?>/catalogue" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>
                                </div>
                                <?php if (!session()->has("numero")): ?>
                                    <h3 class="h3PasArticlePanier">Connectez-vous pour récupérer votre panier.</h3>
                                    <a href="<?= base_url() ?>/connexion" class="lienPanier">Se connecter</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                    <aside>
                        <div class="divValiderVider">
                            <h2>Sous-total (0 article.s) : 0,00€</h2>
                            <a class="lienPanierVide">Valider le panier</a>
                            <a class="lienViderPanier desactive">Vider le panier</a>
                        </div>
                    </aside>
                <?php else: ?>
                    <section class="sectionPanier">
                        <div class="divPanierArticles">
                            <div class="divPanierHeader">
                                    <h2>Votre panier</h2>
                                    <h3>Prix</h3>
                            </div>
                            <?php
                                $sommePrix = 0;
                                $sommeNbArticle = 0;
                                foreach ($produits as $produit):
                                    $sommeNbArticle += 1;
                                    $sommePrix += $produit -> prixTtc;
                            ?>
                                <hr>
                                <article id="<?= $produit->id ?>" class="articlePanier">
                                    <a href="<?= base_url() ?>/produit/<?= $produit->idProd ?>">
                                        <img src="<?= $produit -> lienimage ?>" alt="article 1" title="Article 1">
                                        <div>
                                            <h2>
                                                <?= $produit -> intitule ?>
                                            </h2>
                                            <p class="panierDescription">
                                                <?= $produit -> description ?>
                                            </p>
                                        </div>
                                    </a>
                                    <div>
                                        <div class="divQuantite">
                                            <p>Quantité</p>
                                                <input class="" type="number" name="quantite" min=0 max=<?= $produit->stock ?> value=<?=$produit->quantite ?>>
                                            <a href="<?= base_url() ?>/panier/supprimer/<?= $produit->idProd ?>">Supprimer</a>
                                        </div>
                                        <h3>HT: 
                                            <span class="prixHt" prix="<?= $produit -> prixHt ?>">
                                                <?= $produit -> prixHt ?>€
                                            </span>
                                        </h3>
                                        <h3>TTC: 
                                            <span class="prixTtc" prix="<?= $produit -> prixTtc ?>">
                                                <?= $produit -> prixTtc ?>€
                                            </span> 
                                        </h3>
                                    </div>
                                </article>
                            <?php endforeach; ?>                
                            <hr>
                        </div>
                        <div class="sous-totaux">
                            <h2>Sous-total HT
                                (<span class="nbArt">
                                    <?= $sommeNbArticle ?>
                                </span> article.s) :
                                <span class="totalHt">
                                    <?= $sommePrix ?>
                                </span>€
                            </h2>
                            <h2>Sous-total TTC
                                (<span class="nbArt">
                                    <?= $sommeNbArticle ?>
                                </span> article.s) :
                                <span class="totalTtc">
                                    <?= $sommePrix ?>
                                </span>€
                            </h2>
                        </div>
                    </section>
                    <aside>
                        <div class="divCodeReduc">
                            <h2>Code de réduction</h2>
                            <form action="<?= current_url() ?>" method="post" name="codeReduc">
                                <input type="text" name="code" value="<?= $code ?>" required="required"/>
                                <?= 
                                    afficheErreurs($erreurs, 0) . 
                                    afficheErreurs($erreurs, 1) .
                                    afficheRetours($retours, 0) .
                                    afficheRetours($retours, 1) .
                                    afficheRetours($retours, 2)
                                ?>
                                <input type="submit" value="Valider"/>
                            </form>
                        </div>
                        <div class="divValiderVider">
                            <h2>Sous-total
                                (<span class="nbArt">
                                    <?= $sommeNbArticle ?>
                                </span> article.s) : 
                                <span class="totalTtc <?= $classCacheDiv ?>">
                                    <?= $sommePrix ?> 
                                </span>
                                <span class="totalTtc">
                                    <?= $sommePrix ?>
                                </span>€
                            </h2>
                            <a href="<?= base_url() ?>/livraison" class="lienPanier">Valider le panier</a>
                            <a class="lienViderPanier" href="<?= base_url() ?>/panier/vider">Vider le panier</a>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>
            <?php if (empty($produits)): ?>
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
            <?php endif; ?>
        </main>
<?php require("footer.php"); ?>

<script>
    reqUpdateQuantite(
        "<?php echo  base_url()  .  '/panier/modifier/quantite'?>",
        () => document.querySelectorAll(".divQuantite input"),
        (node) => node.parentNode.parentNode.id,
        (err, resp) => {
            if(!err){
                updatePricePanier();
                updatePriceTotal();
                updateQuantite();
            }
        }
    );
    updatePricePanier()
    updatePriceTotal()
</script>