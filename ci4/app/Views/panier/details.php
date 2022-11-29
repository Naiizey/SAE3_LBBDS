<?php require(__DIR__."/../page_accueil/header.php"); ?>
        </header>
        <main>
            <div class="divPrincipaleDetail">
                <div class="divProgress">
                    <?= "<h2>Commande n°".$numCommande."</h2>"?>
                    <div class="bar">   
                        <progress class="progress-bar-ok" value="87.5" max="100"></progress>       
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
                        <h2>Détail de la commande</h2>
                    <?php print_r($infosCommande); ?>
                        <hr>
                        <div class="divArticles">
                            <div>
                                <div>
                                    <img src="<?=base_url()?>/images/art1.png" alt="">
                                    <p>25 galettes saucisses</p>
                                </div>
                                <p>50 €</p>
                            </div>
                            <hr>
                            <div>
                                <div>
                                    <img src="<?=base_url()?>/images/art2.png" alt="">
                                    <p>25 galettes saucisses</p>
                                </div>
                                <p>50 €</p>
                            </div>
                            <hr>
                            <div>
                                <div>
                                    <img src="<?=base_url()?>/images/art3.png" alt="">
                                    <p>25 galettes saucisses</p>
                                </div>
                                <p>50 €</p>
                            </div>
                            <hr>
                        </div>
                        <div class="divPrix">
                            <p>Total HT : 150€</p>
                            <p>Total TTC : 180€</p>
                        </div>
                    </div>
                    <div class="divDroiteDetail">
                        <div>
                            <h2>Télécharger</h2>
                            <hr>
                            <div class="btnTelecharger">
                                <a href="">Facture</a>
                                <a href="">Preuve d'achat</a>
                                <a href="" class="preuveLivraison">Preuve de livraison</a>
                            </div>
                        </div>
                        <div>
                           <h2>Livraison</h2>
                            <hr>
                            <div class="divDetailLivraison">    
                                <p>Adresse : </p>
                                <p>Livreur : </p>
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