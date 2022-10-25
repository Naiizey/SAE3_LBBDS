<?php require("header.php"); ?>
        </header>
        <main class="mainPanier">
            <section class="sectionPanier">
                <div class="divPanierHeader">
                    <h2>Votre panier</h2>
                    <h3>Prix</h3>
                </div>
                <hr>
                <article class="articlePanierProduit">
                <a href="">
                    <img src="./images/art1.png" alt="article 1" title="Article 1">
                </a>
                <div>
                    <h2>Titre de l'article</h3>
                    <p>description de l'article</p>
                </div>
                <div>
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
                    <a href="">Supprimer</a>
                </div>
                <div>
                    <h3>35.55€</h3>
                </div>
                </article>
                <hr>
                <article class="articlePanierProduit">
                <a href="">
                    <img src="./images/art1.png" alt="article 1" title="Article 1">
                </a>
                <div>
                    <h2>Titre de l'article</h3>
                    <p>description de l'article</p>
                </div>
                <div>
                    <p>Quantité</p>
                    <select name="quantite" id="tabQte">
                        <option value="0">Qté : 0 (Supprimer)</option>
                        <option selected value="1">Qté : 1</option>
                        <option value="2">Qté : 2</option>
                        <option value="3">Qté : 3</option>
                        <option value="4">Qté : 4</option>
                        <option value="5">Qté : 5</option>
                        <option value="6">Qté : 6</option>
                        <option value="7">Qté : 7</option>
                        <option value="8">Qté : 8</option>
                        <option value="9">Qté : 9</option>
                        <option value="10+">Qté : 10+</option>
                    </select>
                    <!-- si jamais l'utilisateur choisie 10+ il se transforme en number à partir de 10 -->
                    <a href="">Supprimer</a>
                </div>
                <div>
                    <h3>19.45€</h3>
                </div>
                </article>
                <hr>
                <h2>Sous-total (2 articles) : 55,00€</h2>
            </section>
            <aside>
                <h2>Sous-total (2 articles) : 55,00€</h2>
                <a href="">Valider le panier</a>
            </aside>
        </main>
<?php require("footer.php"); ?>