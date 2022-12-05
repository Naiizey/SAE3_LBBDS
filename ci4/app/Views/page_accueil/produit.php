<?php require("header.php"); ?>
        <main class="mainProduit">
            <section class="sectionProduit">
                <article>
                    <div class="divGauche">
                        <ul>
                            <li>
                                <img src="<?= $prod -> lienimage ?>" />
                            </li>
                            <li>
                                <img src="<?= $prod -> lienimage ?>" />
                            </li>
                            <li>
                                <img src="<?= $prod -> lienimage ?>" />
                            </li>
                        </ul>
                        <div>
                            <img src="<?= $prod -> lienimage ?>" />
                        </div>
                    </div>
                    <div class="divDroite">
                        <div>
                            <h2><?= ucfirst($prod -> intitule)?></h2>
                            <p class="ParaDescProduit"><?= ucfirst($prod->description) ?></p>
                            <section class="sectionAvis">
                                <h4>Avis clients:</h4>
                                <img src="<?=base_url() ?>/images/produit/avis.png"/>
                            </section>
                        </div>
                        <div class="divAcheterProduit">
                            <?php if ($prod -> stock <= 10): ?>
                            <?= "<p>Faites vite, il n'en reste que " . $prod -> stock . '</p>' ?>
                            <?= (isset($quantitePanier) && $quantitePanier<0)?"<p>Vous avez déjà le produit en $quantitePanier fois dans votre panier</p>":"" ?>
                            <?php endif; ?>
                            <form action= <?= base_url()."/panier/ajouter/$prod->id" ?> method="post">
                                <div class="divQuantiteProduit">
                                    <p>Quantité :</p>
                                    <select name="quantite" id="tabQuant">
                                    <?php for ($i = 1; $i <= $prod->stock && $i<=10 ; $i++): ?>
                                        <?= '<option value="'. $i .'">' . $i . '</option>' . "\n"; ?>
                                    <?php endfor; ?>
                                    <?php if($prod->stock > 10): ?>
                                        <option class="option-plus-10"> 10+ </option>
                                    <?php endif; ?>
                                       
                                    </select>
                                    <input class="input-option-plus-10" type="number" name="quantitePlus" min=0 max=<?= $prod -> stock - ((isset($quantitePanier))?$quantitePanier:0) ?> 
                                    value="<?php 
                                    $max=($prod -> stock - ((isset($quantitePanier))?$quantitePanier:0));
                                    if(10 > $max){
                                        echo $max;
                                    }else{
                                        echo 10;
                                    }
                                    ?>">
                                </div>
                                <div>
                                    <h3><?= "Prix (HT): " . $prod -> prixht ?></h3>
                                    <h3><?= '(TTC): ' . $prod -> prixttc ?></h3>
                                </div>
                                <button type="submit">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </article>
                <section class="sectionRecommandationsPanierPC">
                    <h2>Recommandations</h2>
                    <hr>
                    <ul>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art1.png" alt="article 1" title="Article 1">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art2.png" alt="article 2" title="Article 2">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art3.png" alt="article 3" title="Article 3">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art4.png" alt="article 4" title="Article 4">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art5.png" alt="article 5" title="Article 5">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art5.png" alt="article 6" title="Article 6">
                            </a>
                        </li>
                    </ul>
                </section>
                <section class="sectionRecommandationsPanierMobile">
                    <h2>Recommandations</h2>
                    <hr>
                    <ul>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art1.png" alt="article 1" title="Article 1">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art2.png" alt="article 2" title="Article 2">
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="<?=base_url() ?>/images/art3.png" alt="article 3" title="Article 3">
                            </a>
                        </li>
                    </ul>
                </section>
            </section>
        </main>
<?php require("footer.php"); ?>