    <?php require("header.php"); ?>
        <main class="mainPanier">
            <div class="divPanierEtAside">
                <?php 
                    if (empty($produits))
                    {
                        echo   '<section class="sectionPanier">
                                    <div>
                                        <div class="divPanierHeader">
                                            <h2>Votre panier est vide</h2>
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="h3PasArticlePanier">
                                                <h3>Vous n’avez aucun article dans votre panier.</h3>
                                                <h3><a href="'.base_url()."/catalogue".'"class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>
                                            </div>';

                        
                        if (!session()->has("numero"))
                        {
                            echo '<h3 class="h3PasArticlePanier">Connectez-vous pour récupérer votre panier.</h3>';
                            echo '<a href="' . base_url() . '/connexion" class="lienPanier">Se connecter</a>';
                        } 
                        
                        echo   '        </div>
                                    </div>
                                </section>
                                <aside>
                                    <h2>Sous-total (0 article.s) : 0,00€</h2>
                                    <a class="lienPanierVide">Valider le panier</a>
                                    <a class="lienViderPanier desactive">Vider le panier</a>
                                </aside>';
                    }
                    else
                    {
                        echo   '<section class="sectionPanier">
                                    <div class="divPanierArticles">
                                        <div class="divPanierHeader">
                                                <h2>Votre panier</h2>
                                                <h3>Prix</h3>
                                        </div>';
                        $sommePrix = 0;
                        $sommeNbArticle = 0;
                        foreach ($produits as $produit)
                        {
                            $sommeNbArticle += 1;
                            $sommePrix += $produit -> prixTtc;
                            //print_r($produit);
                            echo       '<hr>
                                        <article id='.$produit->id.' class="articlePanier">
                                            <a href="'.base_url()."/produit/$produit->idProd".'">
                                                <img src="' . $produit -> lienimage . '" alt="article 1" title="Article 1">
                                                <div>
                                                    <h2>' . $produit -> intitule . '</h2>
                                                    <p class="panierDescription">' . $produit -> description . '</p>
                                                </div>
                                            </a>
                                                <div class="divQuantite">
                                                    <p>Quantité</p>
                                                    <select id=forProd-'.$produit->id.' name="quantite">';
                            for ($i = 1; $i <= $produit -> stock; $i++)
                            {
                            
                                
                                    echo                   '<option value="'. $i .'" '. (($produit->quantite == $i)?'selected':'') .' ">' . $i . "</option>";
                                
                            }
                            echo                   '</select>
                                                    <a href="'.base_url()."/panier/supprimer/$produit->idProd".'">Supprimer</a>
                                                </div>
                                                <h3>HT: <span class="prixHt" prix="'. $produit -> prixHt .'" >'. $produit -> prixHt .'€</span> </h3>
                                                <h3>TTC: <span class="prixTtc" prix="'. $produit -> prixTtc .'" >'. $produit -> prixTtc .'€</span> </h3>
                                        </article>';
                        }                
                        echo       '    <hr>
                                    </div>
                                    <div class="sous-totaux">
                                        <h2>Sous-total HT(<span class="nbArt">' . $sommeNbArticle . '</span> article.s) : <span class="totalHt">' . $sommePrix . '</span> €</h2>
                                        <h2>Sous-total TTC(<span class="nbArt">' . $sommeNbArticle . '</span> article.s) : <span class="totalTtc">' . $sommePrix . '</span> €</h2>
                                    </div>
                                </section>
                                <aside>

                                    <h2>Sous-total (<span class="nbArt">' . $sommeNbArticle . '</span> article.s) : <span class="totalTtc">' . $sommePrix . '</span>€</h2>
                                    <a href="'.base_url().'/livraison" class="lienPanier">Valider le panier</a>
                                    <a class="lienViderPanier" href='.base_url().'/panier/vider>Vider le panier</a>
                                </aside>';
                    }
                ?> 
            </div>
            <?php
                if (empty($produits))
                {
                    echo    '<section class="sectionRecommandationsPanier">
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
                            </section>';
                }
            ?>
        </main>       
        <script>
            
        </script>
<?php require("footer.php"); ?>

<script>
    reqUpdateQuantite(
        "<?php echo base_url()  .  '/panier/modifier/quantite'?>",
        () => document.querySelectorAll(".divQuantite select"),
        (node) => node.parentNode.parentNode.id,
        (err, resp) => {
            if(!err){
                updatePricePanier();
                updatePriceTotal();
            }
            

        }

    );
    updatePricePanier()
    updatePriceTotal()
</script>