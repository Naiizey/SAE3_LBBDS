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
                            <?php if (isset($autresImages)): ?>
                                <li>
                                    <a href="" onclick="changeImageProduit(event)">
                                        <img src="<?= $prod -> lienimage ?>" />
                                    </a>
                                </li>
                                <?php for ($i = 0; $i < count($autresImages) && $i < 5; $i++): ?>
                                    <li>
                                        <a href="" onclick="changeImageProduit(event)">
                                            <img src="<?= $autresImages[$i] -> lien_image ?>" />
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            <?php else: ?>
                                <?php for ($i = 0; $i < 3; $i++): ?>
                                    <li>
                                        <img src="<?= $prod -> lienimage ?>" />
                                    </li>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </ul>
                        <div class="zoom" onmousemove="zoomProduit(event)" style="background-image: url(<?= $prod -> lienimage ?>)">
                            <img src="<?= $prod -> lienimage ?>"/>
                        </div>
                    </div>
                    <div class="divDroite">
                        <div>
                            <h2><?= ucfirst($prod -> intitule)?></h2>
                            <p class="ParaDescProduit"><?= ucfirst($prod->description) ?></p>
                            <section class="sectionAvis">
                                <a href="#divLesAvis"><h4>Avis clients :</h4></a>
                                <?php if (empty($avis)): ?>
                                <h4 class="aucunAvis">Aucun avis</h4>
                                <?php else : ?>
                                <div class="noteAvis"><?= $cardProduit->notationEtoile($prod->moyenne) ?></div>
                                <p><?= $prod->moyenne ?>/5</p>
                                <?php endif ?>
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
                                    <h3><?= "Prix : " . $prod -> prixht . "€ HT"?></h3>
                                    <h3><?= $prod -> prixttc . "€ TTC"?></h3>
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
                <div class="divAvis" id="avis">
                    <h2>Avis</h2>
                    <hr>
                    <?php if (empty($avis)): ?>
                    <p id="divLesAvis">Aucun utilisateur n'a laissé d'avis sur cet article.</p>
                    <?php else : ?>
                    <div id="divLesAvis">
                        <div class="moyennesAvis">
                            <?php for ($i=5; $i > 0 ; $i--) : ?>
                            <div>
                                <p class="numAvis"><?= $i ?></p>
                                <progress class="barreAvis" value="0" max="1"></progress>
                                <p class="pAvis"></p>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <div class="divListeAvis">
                            <div class="divAjoutComment">
                                <form action="" method="POST">
                                    <div class="divEtoilesComment">
                                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/Star-empty.svg")?>
                                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/Star-empty.svg")?>
                                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/Star-empty.svg")?>
                                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/Star-empty.svg")?>
                                        <?= file_get_contents(dirname(__DIR__,3)."/public/images/Star-empty.svg")?>
                                        <p>_/5</p>
                                    </div>
                                    <div class="divProfilText">
                                        <img src="<?=base_url() ?>/images/header/profil.svg">
                                        <textarea id="contenuComment" placeholder="Ajouter un commentaire... (optionnel)"></textarea>
                                    </div>
                                    <div class="divBoutonsComment">
                                        <button type="reset" value="Reset">Annuler</button>
                                        <input type="submit" value="Poster">
                                    </div>
                                </form>
                            </div>
                            <?php 
                                end($avis);
                                $fin = key($avis);
                                foreach ($avis as $cle => $unAvis): ?>
                                    <div class="divUnAvis" <?php if ($unAvis->num_avis == $avisEnValeur) {echo 'id="avisEnValeur"';} ?>>
                                        <section class="sectionUnAvis">
                                            <div class="divNomCommentaire">
                                                <img src="<?=base_url() ?>/images/header/profil.svg">
                                                <div class="divNomDate">
                                                    <h3><?= $unAvis->pseudo ?> : </h3>
                                                    <p>Publié le <?= $unAvis->date_av ?></p>
                                                </div>
                                            </div>
                                            <div class="divAvisCommentaire">
                                                <div class="noteAvis"><?= $cardProduit->notationEtoile($unAvis->note_prod) ?></div>
                                                <p><?= $unAvis->note_prod ?>/5</p>
                                            </div>
                                        </section>
                                        <p><?= $unAvis->contenu_av ?></p>
                                        <?php if ($cle != $fin): ?>
                                        <hr>
                                        <?php endif; ?>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
            </section>
        </main>
<?php require("footer.php"); ?>
<script>
    avisProduit();
</script>