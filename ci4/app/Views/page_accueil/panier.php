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
                                            <h3 class="h3PasArticlePanier">Vous n’avez aucun article dans votre panier. <br> <a href="'.base_url()."/catalogue".'" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>';

                        
                        if (!session()->has("numero"))
                        {
                            echo '<h3 class="h3PasArticlePanier">Connectez-vous pour récupérer votre panier.</h3>';
                            echo '<a href="' . base_url() . '/connexion" class="lienPanier">Se connecter</a>';
                        } 
                        
                        echo   '        </div>
                                    </div>
                                </section>
                                <aside>
                                    <h2>Sous-total (0 article) : 00,00€</h2>
                                    <a href="" class="lienPanierVide">Valider le panier</a>
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
                                                <h3 class="prix" prix="'. $produit -> prixTtc .'">' . $produit -> prixTtc . '€</h3>
                                        </article>';
                        }                
                        echo       '    <hr>
                                    </div>
                                    <div class="divPanierFooter"> 
                                        <a href='.base_url().'/panier/vider>Vider le panier</a>
                                        <h2>Sous-total (<span class="nbArt">' . $sommeNbArticle . '</span> articles) : <span class="total">' . $sommePrix . '</span> €</h2>
                                    </div>
                                </section>
                                <aside>
                                    <h2>Sous-total (<span class="nbArt">' . $sommeNbArticle . '</span> articles) : <span class="total">' . $sommePrix . '</span>€</h2>
                                    <a class="lienPanier" href="">Valider le panier</a>
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
            //toSend est un param permettant la modification de la page sans rafraichissement
            var toSend = new Object();
            //url où envoyé les données
            toSend.http = "<?php echo base_url()  .  'panier/modifier/quantite'?>";
            //indication de comment récupérer un select
            toSend.howGetSelect=() => document.querySelectorAll(".divQuantite select");
            //indication de comment l'id du produit d'un select
            toSend.howGetId=(node) => node.parentNode.parentNode.id;
            //indique si non voulons ou non que la console affiche les résultats (true/false) de la requête OU de définir une fonction
            toSend.callback=true;
        </script>
<?php require("footer.php"); ?>