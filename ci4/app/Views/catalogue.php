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

            <details class=categories>
                <summary>Catégories</summary>
            </details>
        </div>
        
    </div>

</main>
<?php require("page_accueil/footer.php"); ?>