<?php require __DIR__ . "/../header.php";
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
                <?php include(dirname(__DIR__, 3)."/public/images/header/logo.svg")?>
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
                        <h2>Total TTC (0 article.s) : 0,00€</h2>
                        <a class="lienPanierVide">Valider le panier</a>
                        <a class="lienViderPanier desactive">Vider le panier</a>
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
                                        <a href="<?= base_url() ?>/panier/supprimer/<?= $produit->idProd ?>">Supprimer</a>
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
                        <a class="lienViderPanier" href="<?= base_url() ?>/panier/vider">Vider le panier</a>
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
                        <h2>Total
                            (<span class="nbArt">
                                <?= $sommeNbArticle ?>
                            </span> article.s) :
                            <span class="totalTtc <?= $classCacheDiv ?>">
                                <?= $sommePrix ?>
                            </span>
                            <span class="totalTtc">
                                <?= $sommePrix ?>
                            </span>€ TTC
                        </h2>
                        <a href="<?= base_url() ?>/facture" class="lienPanier">Valider le panier</a>
                        <a class="lienViderPanier" href="<?= base_url() ?>/panier/vider">Vider le panier</a>
                    </div>
                </aside>
            <?php endif; ?>
        </div>
        <?php if (empty($produits)): ?>
            <section class="sectionRecommandationsPanierPC">
                <h2>Recommandations</h2>
                <hr>
                <ul>
                    <?php $prodsPC = $model->findAll(5);?>
                    <?php foreach($prodsPC as $prod): ?>
                        <li>
                            <?= $cardProduit->display($prod)?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section class="sectionRecommandationsPanierMobile">
                <h2>Recommandations</h2>
                <hr>
                <ul>
                    <?php $prodsMobile = $model->findAll(3);?>
                    <?php foreach($prodsMobile as $prod): ?>
                        <li>
                            <?= $cardProduit->display($prod)?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>
    </main>
<?php require __DIR__ . "/../footer.php"; ?>

<script>
    <?php if (!empty($produits)): ?>
    reqUpdateQuantite(
        "<?php echo  base_url()  .  '/panier/modifier/quantite'?>",
        () => document.querySelectorAll(".divQuantite input"),
        (node) => {
            while(!node.classList.contains("articlePanier")){
                node=node.parentNode;
                
                if(node.nodeName=="MAIN"){
                    throw new Error("Le parent cherché n'as pas été atteint");
                }
            }
            return node.id;
        },
        (err, resp) => {
            if(!err){
                updatePricePanier();
                updatePriceTotal();
                updateQuantite();
            }
        }
    );
    updatePricePanier();
    updatePriceTotal();
    <?php endif; ?>
    <?php if(session()->has("numero") && has_cookie("token_panier")
    && !(session()->has("ignorer") && session()->get("ignorer"))
    && !(isset($ecraserOuFusionner) && $ecraserOuFusionner)): ?>
        var oui = new AlerteAlizon("Récupération panier","<?= current_url() ?>","Il y a déjà un panier associé à votre compte, voulez vous garder le panier que vous venez de faire, garder le panier enregistré sur votre compte ou fusionner les 2 ?");
        oui.ajouterBouton("Garder le nouveau",'normal-button petit-button supprimer-filtre rouge',"SupprAncien");
        oui.ajouterBouton("Garder celui du compte",'normal-button petit-button supprimer-filtre rouge',"SupprActuel");
        oui.ajouterBouton("Plus tard",'normal-button petit-button supprimer-filtre',"Ignorer");
        oui.ajouterBouton("Fusionner",'normal-button petit-button vert',"Confirmer");
        oui.affichage();
    <?php endif; ?>
</script>