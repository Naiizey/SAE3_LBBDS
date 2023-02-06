<?php require("header.php"); ?>
<main>
    <div class="sectionCredit divCredit divEspaceCli recap">
        <div class="sectionTitle">
            <h2>Récapitulatif</h2>
            <!-- on tire un trait -->
            <hr>
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
        <div class="divRecapPanier">
            <div>
                <div class="recap-prod-titre">
                    <h3>Produits à l'achat</h3>
                    <hr>
                </div>
                <div class="recap-prod-container">
                <?php foreach($produits as $produit): ?>
                    <div class="produit">
                        <div>
                            <div class="intitule"><?= $produit->intitule ?> </div> 
                            <div class="price"><div>TTC:</div><div><?= $produit->prixTtc ?>€</div> <div>HT:</div><div><?= $produit->prixHt ?>€</div></div>
                        </div>
                        <hr>
                    </div>
                    <?php endforeach ?>
                </div>
                <div class="recap-prod-container-price">
                    <?php if (isset($reducMont) || isset($reducPourc)): ?>
                    <div>Sous-totaux </div> <div><?= $totalTtc?>€ TTC</div><div></div> <div><?= $totalHt ?>€ HT</div></section>
                    <div>Code de réduction</div> <div><?= "-".((isset($reducMont))?$reducMont."€":$reducPourc."%") ?></div>
                    <?php endif; ?>
                    <div>Total </div> 
                    <?php if (isset($reducMont)): ?>
                        <div><?= $totalTtc-$reducMont ?>€</div> 
                        
                    <?php elseif (isset($reducPourc)): ?>
                        <div><?= $totalTtc*(100-$reducPourc)/100  ?>€ TTC</div>
                    <?php else: ?>
                        <div><?= $totalTtc?>€ TTC</div> 
                        
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
        <div>
            <form action="<?=current_url() ?>" method="get">
                <button class= "gros-bouton" name="Confirmation" value="1">Confirmer</button>
            </form>
        </div>
    </div>

</main>
<?php require("footer.php"); ?>