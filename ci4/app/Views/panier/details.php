<?php require(__DIR__."/../page_accueil/header.php"); ?>
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
                                        <img src="<?= $article -> lien_image_prod ?>" alt="article 1" title="Article 1">
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
                                <?php echo '
                                    <p>Rue : '.$adresse[0]->numero_rue.' '.$adresse[0]->nom_rue.'</p>
                                    <p>Ville : '.$adresse[0]->code_postal.' '.$adresse[0]->ville.'</p>'
                                ?>  
                                <p>N° de suivi : </p>
                                <p>Lien du suivi : </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
<?php require(__DIR__."/../page_accueil/footer.php"); ?>
<script>
    barreProgression();
</script>