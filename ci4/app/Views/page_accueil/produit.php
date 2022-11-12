<?php require("header.php"); ?>
        <main class="mainProduit">
            <section class="sectionProduit">
                <article>
                    <div class="divGauche">
                        <div class="divImagesProduits">
                            <ul>
                                <li>
                                    <img src="<?=base_url() ?>/images/art5.png" />
                                </li>
                                <li>
                                    <img src="<?=base_url() ?>/images/art5.png" />
                                </li>
                                <li>
                                    <img src="<?=base_url() ?>/images/art5.png" />
                                </li>
                            </ul>
                            <div>
                                <img src="<?=base_url() ?>/images/art5.png" />
                            </div>
                        </div> 
                        <p><?php echo $prod->description;?></p>
                    </div>
                    <div class="divDroite">
                        <div>
                            <h2>Galettes saucisses</h2>
                            <h3>Prix: 0.01€</h3>
                            <h4>Avis clients:</h4>
                            <div class="divAvisLogos">
                                <img src="<?=base_url() ?>/images/produit/avis.png"/>
                                <div>
                                    <img src="<?=base_url() ?>/images/produit/produits_locaux.png" />
                                    <img src="<?=base_url() ?>/images/produit/livraison_gratuite.png" />
                                </div>
                            </div>
                            <div class="divQuantitePanier">
                                <p>Faites vite, il n'en reste que 3</p>
                                <form action=<?=base_url()."/panier/ajouter/$prod->id"?> method="post">
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
                                <button type="submit">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
                <h3>Suggestions :</h3>
                <ul>
                    <li>
                        <figure>
                            <img src="<?=base_url() ?>/images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="<?=base_url() ?>/images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="<?=base_url() ?>/images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="<?=base_url() ?>/images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                    <li>
                        <figure>
                            <img src="<?=base_url() ?>/images/art5.png" />
                            <figcaption>Nom article</figcaption>
                        </figure>
                    </li>
                </ul>
            </section>
        </main>
<?php require("footer.php"); ?>