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
                                <h3>Vous n’avez aucun article dans votre quidi.</h3>
                                <h3><a href="<?= base_url() ?>/vendeur/catalogue" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>
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
                                <h2>Votre quidi (<span class="nbArt"> <?= sizeof($produits)?> </span> article.s) : </h2>
                        </div>
                        <hr>
                        <?php
                            $sommePrix = 0;
                            $sommeNbArticle = 0;
                            foreach ($produits as $produit):
                                $sommeNbArticle += 1;
                                $sommePrix += $produit -> prixTtc;
                        ?>
                            <div class="liste-produits">
                                
                            </div>
                        <?php endforeach; ?>
                        <div class="bloc-erreur-liste-produit <?= (isset($message))?"":"hidden"; ?>">
                            <p class="paragraphe-erreur">
                                <?= (isset($message))?$message:"" ?>
                            </p>
                            <div class="erreur-liste-produit">
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="sous-totaux">
                        <a class="lienViderPanier" href="<?= base_url() ?>/vendeur/quidi/vider">Vider le quidi</a>
                    </div>
                </section>
                <aside>
                    <div class="divValiderVider">
                        <h2>Total
                            (<span class="nbArt">
                                <?= $sommeNbArticle ?>
                            </span> article.s) :
                        </h2>
                        <a href="<?= base_url() ?>/vendeur/quidi/validation" class="lienPanier">Valider le quidi</a>
                        <a class="lienViderPanier" href="<?= base_url() ?>/vendeur/quidi/vider">Vider le quidi</a>
                    </div>
                </aside>
            <?php endif; ?>
        </div>
    </main>
<?php require("footer.php"); ?>

<script>
    var gestCards = QuidiUpdate(document.querySelector(".liste-produits"));

    gestCards.generer(<?= sizeof($produits) ?>);    
</script>