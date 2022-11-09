<?php require("page_accueil/header.php"); ?>
<main id=Catalogue>
    <div class="liste-produits">
    <?php foreach($prods as $prod): ?>
        <?= $cardProduit->display($prod)?>
    <?php endforeach; ?>
    
    </div>
    <div class="liste-categories">
        <div class="titre-categorie">
            <h1>Catégories</h1>
        </div>

        
        <?php foreach ($categories as $categorie):?>
        <div class="categorie-catalogue">
            <details> <summary class="categorie"><h2><?=$categorie->libelle?></h2></summary>
                <ul class="liste-sous-categories">
                    <?php foreach ($categorie->getAllSousCat() as $sousCat): ?>
                        <a href="./catalogue?cat=<?=$categorie->codeCat?>&sousCat=<?=$sousCat->codeCat?>"><li class=".sous-categorie-catalogue"><h3><?= $sousCat->libelle ?></h3></li></a>
                    <?php endforeach;?>
                </ul>
            </details>
        <?php endforeach;?>
        </div>
        
        
        
    </div>

</main>
<?php require("page_accueil/footer.php"); ?>