<?php require("header.php"); ?>
        <main class="mainProduit">
            <section class="sectionProduit">
                <article>
                    <div class="divGauche">
                        <div class="divImagesProduits">
                            <ul>
                                <li>
                                    <img src="images/art5.png" />
                                </li>
                                <li>
                                    <img src="images/art5.png" />
                                </li>
                                <li>
                                    <img src="images/art5.png" />
                                </li>
                            </ul>
                            <div>
                                <img src="images/art5.png" />
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit enim laudantium quia fugit incidunt impedit, fugiat officia mollitia veniam, quos voluptatum ullam rem voluptatem repudiandae corporis nam quis aliquid similique? Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odio eum architecto, inventore eaque consequuntur quod dolor commodi soluta iure quasi, minus magnam in repudiandae recusandae repellat ipsam consectetur facere nobis?</p>
                    </div>
                    <div class="divDroite">
                        <div>
                            <h2>Galettes saucisses</h2>
                            <h3>Prix: 0.01€</h3>
                            <h4>Avis clients:</h4>
                            <div class="divAvisLogos">
                                <img src="images/produit/avis.png"/>
                                <div>
                                    <img src="images/produit/produits_locaux.png" />
                                    <img src="images/produit/livraison_gratuite.png" />
                                </div>
                            </div>
                            <div class="divQuantitePanier">
                                <p>Faites vite, il n'en reste que 3</p>
                                <div>
                                    <p>Quantité :</p>
                                    <select name="quantite" id="tabQuant">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
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
                                    <!-- si jamais l'utilisateur choisi 10+ il se transforme en number à partir de 10 -->
                                </div>
                            </div>
                        </div>
                        <a href="">Ajouter au panier</a>
                    </div>
                </article>
                <h3>Suggestions :</h3>
                <ul>
                    <li>
                        <figure>
                            <img src="images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                </ul>
            </section>
        </main>
<?php require("footer.php"); ?>