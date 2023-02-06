<?php require __DIR__."/../header.php"; ?>
        </header>
        <main>
            <div class="divPrincipaleDetail">
                <div class="divProgress">
                    <?= "<h2>Commande n°".$numCommande."</h2>"?>
                    <div class="bar">
                        <?= '<progress class="progress-bar-ok" value="'.$infosCommande[0]->etat.'" max="100"></progress>'?> 
                        <div class="buttonProgress">
                            <div>
                                <div class="pointProgress"></div>
                                <p>Commandée</p>
                            </div>
                            <div>
                                <div class="pointProgress"></div>
                                <p>Expédiée</p>
                            </div>
                            <div>
                                <div class="pointProgress"></div>
                                <p>Plateforme régionale</p>
                            </div>
                            <div>
                                <div class="pointProgress"></div>
                                <p>Plateforme Locale</p>
                            </div>
                            <div>
                                <div class="pointProgress"></div>
                                <p>Livrée</p>
                            </div>
                        </div>
                    </div>
                    <p>
                    <?php
                            if($infosCommande[0]->etat == 1){
                                echo "Commandée";
                            }
                            else if($infosCommande[0]->etat == 2){
                                echo "Expédiée";
                            }
                            else if($infosCommande[0]->etat == 3){
                                echo "Plateforme régionale";
                            }
                            else if($infosCommande[0]->etat == 4){
                                echo "Plateforme Locale";
                            }
                            else if($infosCommande[0]->etat == 5){
                                echo "Livrée";
                            }
                            else{
                                echo "Commande terminée";
                            }
                        ?>
                    </p>
                </div>
                <div class="divBasPageDetail">
                    <section class="sectionPanier mainPanier divDetail">
                        <div class="divPanierArticles">
                            <div class="divPanierHeader">
                                    <h2>Votre commande (<span class="nbArt"> <?= sizeof($articles)?> </span> article.s) :</h2>
                                    <h3>Prix</h3>
                            </div>
                            <?php
                                foreach ($articles as $article):
                            ?>
                                <hr>
                                <article id="<?= $article->id_prod ?>" class="articlePanier">
                                    <a href="<?= base_url() ?>/produit/<?= $article->id_prod ?>">
                                        <img src="<?= $article -> lienimage ?>">
                                        <div>
                                            <h2>
                                                <?= $article -> intitule_prod ?>
                                            </h2>
                                            <p class="panierDescription">
                                                <?= $article -> description_prod ?>
                                            </p>
                                        </div>
                                    </a>
                                    <div>
                                        <div class="divQuantite">
                                            <p>Quantité : <?= $article->qte?></p>
                                        </div>
                                        <h3>
                                            <span class="prixHt" prix="<?= $article -> prix_ht ?>">
                                                <?= $article -> prix_ht ?>€
                                            </span> HT
                                        </h3>
                                        <h3>
                                            <span class="prixTtc" prix="<?= $article -> prix_ttc ?>">
                                                <?= $article -> prix_ttc ?>€
                                            </span> TTC
                                        </h3>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                            <hr>
                        </div>
                        <div class="sous-totaux divSousTotauxDetailCommande">
                            <div>
                                <h2>Sous-totaux :
                                    <span class="totalHt">
                                        <?= $infosCommande[0]->prix_ht ?>
                                    </span>€ HT
                                </h2>
                                <h2>
                                    <span class="totalTtc">
                                        <?= $infosCommande[0]->prix_ttc ?>
                                    </span>€ TTC
                                </h2>
                                <br>
                                <?php if ($infosCommande[0]->montant_reduction !=0): ?>
                                <h2>
                                    <?="Montant réduction : ".$infosCommande[0]->montant_reduction."€"?>
                                </h2>
                                <h2>Prix total : <?= $infosCommande[0]->prix_ttc-$infosCommande[0]->montant_reduction ?>€</h2>
                                <?php elseif ($infosCommande[0]->pourcentage_reduction != 0): ?>
                                <h2>
                                    <?="Pourcentage réduction : ".$infosCommande[0]->pourcentage_reduction."%"?>
                                </h2>
                                <h2>Prix total : <?= $infosCommande[0]->prix_ttc*(1-($infosCommande[0]->pourcentage_reduction/100)) ?>€</h2>
                                <?php endif ?>
                            </div>
                        </div>
                    </section>
                    <div class="divDroiteDetail">
                        <div>
                            <h2>Télécharger</h2>
                            <hr>
                            <div class="btnTelecharger">
                                <a href="<?= base_url() ?>/fichiers_telechargeables/Facture.txt" download>Facture</a>
                                <a href="<?= base_url() ?>/fichiers_telechargeables/Preuve_achat.txt" download>Preuve d'achat</a>
                                <a href="<?= base_url() ?>/fichiers_telechargeables/Facture.txt" download class="preuveLivraison">Preuve de livraison</a>
                            </div>
                        </div>
                        <div>
                            <h2>Livraison</h2>
                            <hr>
                            <div class="divDetailLivraison">
                                <p>Rue : <?= $adresse->numero_rue.' '.$adresse->nom_rue ?></p>
                                <p>Ville : <?= $adresse->code_postal.' '.$adresse->ville ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?php require __DIR__."/../footer.php"; ?>
<script>
    barreProgression();
</script>