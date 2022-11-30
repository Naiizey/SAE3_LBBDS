<?php require(__DIR__."/../page_accueil/header.php"); ?>
        </header>
        <main>
            <div class="divPrincipaleDetail">
                <div class="divProgress">
                    <?= "<h2>Commande n°".$numCommande."</h2>"?>
                    <div class="bar">  
                        <progress class="progress-bar-ok" value="1" max="100"></progress> 
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
                        <hr>
                        <div class="divArticles">
                            <?php 
                                foreach ($articles as $article) {
                                    echo '
                                        <div>
                                            <div>
                                                <img>
                                                <p>'.$article->intitule_prod.'</p>
                                            </div>
                                            <p>'.$article->prix_ht.'€</p>
                                        </div>
                                        <hr>';
                                }
                            ?>
                        </div>
                        <div class="divPrix">
                            <?= "<p>Total HT : ".$infosCommande[0]->prix_ht."€</p>
                            <p>Total TTC : ".$infosCommande[0]->prix_ttc."€</p>"?>
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