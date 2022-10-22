<?php require("header.php"); ?>
        </header>
        <main>
            <section class="sectionPanier">
                <h2>Votre panier</h2>
                <hr>
                <article class="articleProduit">
                <a href="">
                    <img src="./images/art1.png" alt="article 1" title="Article 1">
                </a>
                <div>
                    <h3>Titre de l'article</h3>
                    <p>description de l'article</p>
                </div>
                <div>
                    <p>Quantité</p>
                    <input type="number" name="quantite" id="quantite" min="0" max="10" value="1">
                    <a href="">Supprimer</a>
                </div>
                <div>
                    <h3>100$</h3>
                </div>
                <hr>
                </article>
                <article class="articleProduit">
                <a href="">
                    <img src="./images/art1.png" alt="article 1" title="Article 1">
                </a>
                <div>
                    <h3>Titre de l'article</h3>
                    <p>description de l'article</p>
                </div>
                <div>
                    <p>Quantité</p>
                    <input type="number" name="quantite" id="quantite" min="0" max="10" value="1">
                    <a href="">Supprimer</a>
                </div>
                <div>
                    <h3>100$</h3>
                </div>
                <hr>
                </article>
                <h2>Sous-total : 55,00€</h2>
            </section>
            <aside>
                <h2>Sous-total : 55,00€</h2>
                <a href="">Valider le panier</a>
            </aside>
        </main>
<?php require("footer.php"); ?>