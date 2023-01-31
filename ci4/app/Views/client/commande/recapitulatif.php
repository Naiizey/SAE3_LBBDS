<?php require(dirname(__DIR__) . "/header.php"); ?>
<main>
    <div class="sectionCredit divCredit divEspaceCli recap">
        <h2>Récapitulatif</h2>
        <div class="divRecapPanier">
            <div>
                <h3>Produits à l'achat</h3>
                <div class="recap-prod-container">
                <?php foreach($produits as $produit): ?>
                    <div><?= $produit->intitule ?> </div> <div><?= $produit->prixTtc ?>€ TTC</div> <div><?= $produit->prixHt ?>€ HT</div>
                <?php endforeach ?>
                </div>
                <div class="recap-prod-container">
                    <?php if (isset($reducMont) || isset($reducPourc)): ?>
                    <div>Sous-totaux </div> <div><?= $totalTtc?>€ TTC</div> <div><?= $totalHt ?>€ HT</div>
                    <div>Code de réduction</div> <div><?= "-".((isset($reducMont))?$reducMont."€":$reducPourc."%") ?></div> <div></div>
                    <?php endif; ?>
                    <div>Total </div> 
                    <?php if (isset($reducMont)): ?>
                        <div><?= $totalTtc-$reducMont ?>€</div> 
                        
                    <?php elseif (isset($reducPourc)): ?>
                        <div><?= $totalTtc*(100-$reducPourc)/100  ?>€ TTC</div>
                    <?php else: ?>
                        <div><?= $totalTtc?>€ TTC</div> 
                        
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
                <h3>Votre adresse de livraison :</h3>
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
<?php require(dirname(__DIR__) . "/footer.php"); ?>