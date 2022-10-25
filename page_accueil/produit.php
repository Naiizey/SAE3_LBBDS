<?php require("header.php"); ?>
            <nav>
                <ul>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 1</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 2</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 3</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 4</a>
                    </li>
                    <li class="liCategorie">
                        <a class="categorie" href="">Catégorie 5</a>
                    </li>
                </ul>
            </nav>
        </header>
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
                        <h2>Galettes saucisses</h2>
                        <h3>Prix: 0.01€</h3>
                        <h4>Avis clients:</h4>
                        <div class="avisEtLogos">
                            <img src="images/"/>
                            <div>
                                <img src="images/" />
                                <img src="images/" />
                            </div>
                        </div>
                        <div>
                            <p>Faites vite, il n'en reste que 3</p>
                            <p>Quantité</p>
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
                            <!-- si jamais l'utilisateur choisie 10+ il se transforme en number à partir de 10 -->
                            <a href=""></a>
                        </div>
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