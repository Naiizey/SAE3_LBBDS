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
                    <div class="divDetail">
                        <div>
                            <h2>Détail de la commande</h2>
                            <hr>
                            <div class="divArticles">
                                <?php foreach ($articles as $article) {
                                    echo '
                                        <div>
                                            <div>
                                                <a href='.base_url()."/produit/".$article->id_prod.'>
                                                    <img src='.$article->lien_image_prod.'>
                                                </a>
                                                <a href='.base_url()."/produit/".$article->id_prod.'>
                                                    <p>'.$article->intitule_prod.'</p>
                                                </a>
                                            </div>
                                            <p>'.$article->prix_ht.'€</p>
                                        </div>
                                        <hr>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="divPrix">
                            <?= "<p>Totaux : ".$infosCommande[0]->prix_ht."€ HT</p>
                            <p>".$infosCommande[0]->prix_ttc."€ TTC</p>"?>
                        </div>
                    </div>
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
                                    <p>Adresse : '.$adresse->numero_rue.' '.$adresse->nom_rue.'</p>
                                    <p>'.$adresse->code_postal.' '.$adresse->ville.'</p>'
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