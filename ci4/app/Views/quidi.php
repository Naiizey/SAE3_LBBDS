<?php require($context."/header.php"); 
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
                <?php include(dirname(__DIR__, 2)."/public/images/header/logo.svg")?>
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
                                <h3>Vous n’avez aucun article dans votre quidi.</h3>
                                <h3><a href="<?= base_url()."/$context" ?>/catalogue" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>
                            </div>
                        </div>
                    </div>
                </section>
                <aside>
                    <div class="divValiderVider">
                        <a class="lienPanierVide">Valider le quidi</a>
                        <a class="lienViderPanier desactive">Vider le quidi</a>
                    </div>
                </aside>
            <?php else: ?>
                <section class="sectionPanier">
                    <div class="divPanierArticles">
                        <div class="divPanierHeader">
                                <h2>Votre panier (<span class="nbArt"> <?= sizeof($produits)?> </span> article.s) :</h2>
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
                                            <input class="" type="number" name="quantite" min=1 max=<?= $produit->stock ?> value=<?=$produit->quantite ?>>
                                        <a href="<?= base_url()."/$context" ?>/quidi/supprimer/<?= $produit->idProd ?>">Supprimer</a>
                                    </div>
                                    <h3>
                                        <span class="prixHt" prix="<?= $produit -> prixHt ?>">
                                            <?= $produit -> prixHt ?>€
                                        </span> HT
                                    </h3>
                                    <h3>
                                        <span class="prixTtc" prix="<?= $produit -> prixTtc ?>">
                                            <?= $produit -> prixTtc ?>€
                                        </span> TTC
                                    </h3>
                                </div>
                            </article>
                        <?php endforeach; ?>
                        <hr>
                    </div>
                    <div class="sous-totaux">
                        <a class="lienViderPanier" href="<?= base_url()."/$context" ?>/quidi/vider">Vider le panier</a>
                        <div>
                            <h2>Sous-totaux :
                                <span class="totalHt">
                                    <?= $sommePrix ?>
                                </span>€ HT
                            </h2>
                            <h2>
                                <span class="totalTtc">
                                    <?= $sommePrix ?>
                                </span>€ TTC
                            </h2>
                        </div>
                    </div>
                </section>
                <aside>
                    <div class="divValiderVider">
                        <h2>Total
                            (<span class="nbArt">
                                <?= $sommeNbArticle ?>
                            </span> article.s) :
                          
                        </h2>
                        <a href="<?= base_url()."/$context" ?>/quidi/validation" class="lienPanier">Valider le quidi</a>
                        <a class="lienViderPanier" href="<?= base_url()."/$context" ?>/quidi/vider">Vider le quidi</a>
                    </div>
                </aside>
            <?php endif; ?>
        </div>

    </main>
<footer>
<?php require($context."/footer.php"); ?>

