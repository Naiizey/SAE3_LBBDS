<?php require("header.php"); 
    function afficheErreurs($e, $codeE)
    {
        if (isset($e[$codeE]))
        {
            return "<div class='bloc-erreurs'>
                                <p class='paragraphe-erreur'>$e[$codeE]</p>
                    </div>";
        }   
    }  
?>
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
                                <li>
                                    <img src="<?= $prod -> lienimage ?>" />
                                </li>
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
                                <a href="#avis"><h4>Avis clients :</h4></a>
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
                    <p>Soyez le premier à commenter ce produit.</p>
                    <?php endif ?>
                    <div class="divLesAvis">

                        <?php if (!empty($avis)): ?>
                        <div class="moyennesAvis">
                            <?php for ($i=5; $i > 0 ; $i--) : ?>
                            <div>
                                <p class="numAvis"><?= $i ?></p>
                                <progress class="barreAvis" value="0" max="1"></progress>
                                <p class="pAvis"></p>
                            </div>
                            <?php endfor; ?>
                        </div>
                        <?php endif ?>


                        <div class="divListeAvis">

                            
                            <?php if (!empty($avis) && (session()->has("numero"))): ?>
                            <div class="divAjoutComment">
                            <?php elseif ((!empty($avis)) && (!session()->has("numero"))): ?>
                            <div class="divAjoutCommentConnect divConnectPetit">
                                <p>Vous devez vous connecter pour commenter</p>
                                <a href="">Se connecter</a>
                            </div>
                            <div class="divAjoutComment divAjoutCommentBlur">
                            <?php elseif ((empty($avis)) && (!session()->has("numero"))): ?>
                            <div class="divAjoutCommentConnect divConnectGrand">
                                <p>Vous devez vous connecter pour commenter</p>
                                <a href="">Se connecter</a>
                            </div>
                            <div class="divAjoutComment divAjoutCommentBlur divAjoutCommentVide">
                            <?php elseif ((empty($avis)) && (session()->has("numero"))): ?>
                            <div class="divAjoutComment divAjoutCommentVide">
                            <?php endif ?>                                
                                <form action="<?= current_url()."#avis" ?>" method="post">
                                    <div class="divEtoilesComment">
                                        <?php for ($i=0; $i < 5 ; $i++) : ?>
                                        <?= file_get_contents(dirname(__DIR__,2)."/public/images/Star-empty.svg")?>
                                        <?php endfor; ?>
                                        <p>_/5</p>
                                        <input type="text" class="inputInvisible" name="noteAvis">
                                    </div>
                                    <div class="divProfilText">
                                        <img src="<?=base_url() ?>/images/header/profil.svg">
                                        <input type="textarea" name="contenuAvis" placeholder="Ajouter un commentaire... (optionnel)" autocomplete="off"></textarea>
                                    </div>
                                    <?= afficheErreurs($erreurs,0) . afficheErreurs($erreurs,1) ?>
                                    <div class="divBoutonsComment">
                                        <button type="reset" value="Reset">Annuler</button>
                                        <div>
                                            <input type="submit" value="Poster">
                                        </div>
                                    </div>
                                </form>
                            </div>

                            
                            <?php if (!empty($avis)): ?>
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
                                            <div class="divAvisContenuEtSignal">
                                                <p><?= $unAvis->contenu_av ?></p>
                                                <a href="<?= current_url() ?>#avis">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                        <path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/>
                                                    </svg>
                                                </a>
                                            </div>
                                            <form action="<?= current_url()."#avis" ?>" method="post">
                                                <input type="text" class="inputInvisible" name="idAvis" value="<?= $unAvis->num_avis ?>">
                                                <input type="submit" class="inputInvisible" name="signalerAvis" value="Signaler">
                                            </form>
                                            <?php if ($cle != $fin): ?>
                                            <hr>
                                            <?php endif; ?>
                                        </div>
                                <?php endforeach; ?>
                            <?php endif ?>


                        </div>
                    </div>
                    

                </div>
            </section>
        </main>
<?php require("footer.php"); ?>
<script>
    avisProduit();
</script>