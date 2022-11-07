<?php require("header.php"); ?>
        <main class="mainPanier">
            <section class="sectionPanier">
                <div class="divPanierHeader">
                    <h2>Votre panier</h2>
                    <h3>Prix</h3>
                </div>
                <hr>
                <article class="articlePanier">
                    <a href="">
                        <img src="./images/art1.png" alt="article 1" title="Article 1">
                        <div>
                            <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum a ad qui cumque ...</h2>
                            <p class="panierDescription">Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus eveniet facilis maxime veniam ... </p>
                        </div>
                    </a>
                        <div class="divQté">
                            <p>Quantité</p>
                            <select name="quantite" id="tabQuant1">
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
                            <!-- si jamais l'utilisateur choisie 10+ il se transforme en number à partir de 10 -->
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
                        <div class="divQté">
                            <p>Quantité</p>
                            <select name="quantite" id="tabQuant2">
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
                            <!-- si jamais l'utilisateur choisie 10+ il se transforme en number à partir de 10 -->
                            <a href="">Supprimer</a>
                        </div>
                        <h3>35,55€</h3>
                </article>
                <hr>
                <div class="divPanierFooter">
                    <a href="">Vider le panier</a>
                    <h2>Sous-total (2 articles) : 55,00€</h2>
                </div>
            </section>
            <aside>
                <h2>Sous-total (2 articles) : 55,00€</h2>
                <a class="lienPanier" href="">Valider le panier</a>
            </aside>
        </main>
<?php require("footer.php"); ?>