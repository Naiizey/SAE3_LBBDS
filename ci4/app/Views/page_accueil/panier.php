<?php require("header.php"); ?>
        <main class="mainPanier">
            <div class="divPanierEtAside">
                <?php 
                    if ($controller == "panierVide")
                    {
                        echo   '<section class="sectionPanier">
                                    <div>
                                        <div class="divPanierHeader">
                                            <h2>Votre panier est vide</h2>
                                        </div>
                                        <hr>
                                        <div>
                                            <h3 class="h3PasArticlePanier">Vous n’avez aucun article dans votre panier. <br> <a href="index.php" class="lienPasArticlePanier">Cliquez ici</a>, pour continuer vos recherches.</h3>';

                        $connecte = true;
                        if ($connecte == false)
                        {
                            echo "<h3 class='h3PasArticlePanier'>Connectez-vous pour récupérer votre panier.</h3>";
                            echo "<a href=connexion.php class='lienPanier'>Se connecter</a>";
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
                                    <div class="divPanierHeader">
                                            <h2>Votre panier</h2>
                                            <h3>Prix</h3>
                                    </div>
                                    <div class="divPanierArticles">
                                        <hr>
                                        <article class="articlePanier">
                                            <a href="">
                                                <img src="./images/art1.png" alt="article 1" title="Article 1">
                                                <div>
                                                    <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum a ad qui cumque ...</h2>
                                                    <p class="panierDescription">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus eveniet facilis maxime veniam ... </p>
                                                </div>
                                            </a>
                                                <div class="divQuantite">
                                                    <p>Quantité</p>
                                                    <select name="quantite">
                                                        <option value="0">0 (Supprimer)</option>
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10+">10+</option>
                                                    </select>
                                                    <a href="">Supprimer</a>
                                                </div>
                                                <h3>19,45€</h3>
                                        </article>
                                        <hr>
                                        <article class="articlePanier">
                                            <a href="">
                                                <img src="./images/art2.png" alt="article 2" title="Article 2">
                                                <div>
                                                    <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit.</h2>
                                                    <p class="panierDescription">Lorem ipsum dolor sit amet consectetur, adipisicing elit. </p>
                                                </div>
                                            </a>
                                            <div class="divQuantite">
                                                <p>Quantité</p>
                                                <select name="quantite">
                                                    <option value="0">0 (Supprimer)</option>
                                                    <option value="1" selected>1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10+">10+</option>
                                                </select>
                                                <a href="">Supprimer</a>
                                            </div>
                                            <h3>35,55€</h3>
                                        </article>
                                        <hr>
                                    </div>
                                    <div class="divPanierFooter"> 
                                        <a href="">Vider le panier</a>
                                        <h2>Sous-total (2 articles) : 55,00€</h2>
                                    </div>
                                </section>
                                <aside>
                                    <h2>Sous-total (2 articles) : 55,00€</h2>
                                    <a class="lienPanier" href="">Valider le panier</a>
                                </aside>';
                    }
                ?> 
            </div>
            <?php
                if ($controller == 'panierVide')
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
<?php require("footer.php"); ?>