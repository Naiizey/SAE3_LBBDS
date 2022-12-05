<?php require("header.php"); ?>
    <style>
        .sectionRecommandationsPanierPC ul li{
            display: flex;
            justify-content: center;
        }

        .sectionRecommandationsPanierPC .card-produit-ext{
            width: 8rem;
            height: 11.2rem;
            padding: 0;
        }

        .card-produit{
            width: 8rem;
            height: 11.2rem;
        }

        .image-card{
            height: 5.5rem
        }

        .contain-libelle{
            min-height: 2rem;
            max-height: 2rem;
            font-size: 1rem;
        }

        .prix-card{
            font-size: 1rem;
        }

        .addPanier{
            width: 1rem;
            height: 1rem;
        }

        .addPanier svg{
            position: relative;
            top: -.7rem;
        }

        .noation-card{
            height: 1.25rem;
        }

        .card-produit img{
            border: none;
            width: 1rem;
        }
    </style>
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
                                    <h3><?= "Prix (HT): " . $prod -> prixht . "€"?></h3>
                                    <h3><?= '(TTC): ' . $prod -> prixttc . "€"?></h3>
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
                        <?php $prodsPC = $model->where("intitule <>", $prod->intitule)->findAll(5);?>
                        <?php foreach($prodsPC as $prod): ?>
                            <li>
                                <?= $cardProduit->display($prod)?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
                <section class="sectionRecommandationsPanierMobile">
                    <h2>Recommandations</h2>
                    <hr>
                    <ul>
                        <?php $prodsMobile = $model->where("intitule <>", $prod->intitule)->findAll(3);?>
                        <?php foreach($prodsMobile as $prod): ?>
                            <li>
                                <?= $cardProduit->display($prod)?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </section>
        </main>
<?php require("footer.php"); ?>