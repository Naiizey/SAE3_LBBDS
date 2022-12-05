<?php require("page_accueil/header.php"); ?>
<main>
    <div class="sectionCredit divCredit divEspaceCli recap">
        <h2>Récapitulatif</h2>
        <div class="divRecapPanier">
            <div>
                <h3>Produits à l'achat</h3>
                <div class="recap-prod-container">
                <?php foreach($produits as $produit): ?>
                    <div><?= $produit->intitule ?> </div> <div>ttc:<?= $produit->prixTtc ?>€</div> <div>ht:<?= $produit->prixHt ?>€</div>
                <?php endforeach ?>
                </div>
                <div class="recap-prod-container">
                    <?php if (isset($reducMont) || isset($reducPourc)): ?>
                    <div>Sous-totaux </div> <div>ttc:<?= $totalTtc?>€</div> <div>ht:<?= $totalHt ?>€</div>
                    <div>Remise</div> <div><?= "-".((isset($reducMont))?$reducMont."€":$reducPourc."%") ?></div> <div></div>
                    <?php endif; ?>
                    <div>Total </div> 
                    <?php if (isset($reducMont)): ?>
                        <div><?= $totalTtc-$reducMont ?>€</div> 
                        
                    <?php elseif (isset($reducPourc)): ?>
                        <div>ttc:<?= $totalTtc*(100-$reducPourc)/100  ?>€</div> 
                     
                    <?php else: ?>
                        <div>ttc:<?= $totalTtc?>€</div> 
                        
                    <?php endif; ?>
                    <div></div>
                    
                </div>
            </div>
        </div>
        <div class="divAdressesCli adresseRecap">
            <div>
                <h3>Votre adresse de facturation :</h3>
                <ul>
                    
                        <?php foreach ($adresseFact->getAll() as $champs): ?>
                            <li>
                                <?=$champs?>
                            </li>
                        <?php endforeach; ?>
                    
                </ul>
            </div>
            <div>
                <h3>Vote adresse de livraison :</h3>
                <ul>
                    
                        <?php foreach ($adresseLivr->getAll() as $champs): ?>
                            <li>
                                <?=$champs?>
                            </li>
                        <?php endforeach; ?>
                   
                </ul>    
            </div>
        </div> 
        <form action="<?=current_url() ?>" method="get">
            <button class= "gros-bouton" name="Confirmation" value="1">Confirmer</button>
        </form>
    </div>
</main>
<?php require("page_accueil/footer.php"); ?>