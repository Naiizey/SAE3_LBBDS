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
                    <input type="number" name="quantite" id="quantite" min="0" max="10" value="1">
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
                    <input type="number" name="quantite" id="quantite" min="0" max="10" value="1">
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