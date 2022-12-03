<?php require("page_accueil/header.php"); ?>

<?php model("\App\Models\ProduitCatalogue")->selectMax('prixttc')?>
<main id=Catalogue>
    <button class="mobile-ouvrir-filtres">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                </svg>
                Filtres
            </h2>
    </button>
    
    <section class="partie-filtre">
        <div class="liste-filtre">
            <div class="titre-filtre">
                <h1>Filtres</h1>
                <button class="fermer-filtre">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                </svg>
                </button>
            </div>
            <div class="onglets">
                <div class="onglet onglet-selectionnee"><h3>Catégorie</h3></div>
                <div class="onglet"><h3>Détail</h3></div>
            </div>
            <form name="filters" method="get">
                <div class="categorie-catalogue">
                <?php foreach ($categories as $categorie):?>
                    <details>
                        <summary class="categorie"><h2><?=$categorie->libelle?></h2></summary>
                        <!-- Boutton selectionner toutes les sous catégories -->
                        <div id="entête" class="enTete-<?= $categorie->libelle ?>">
                            <div class="bouton-selectionner-tout">
                            <label for="tout-<?=$categorie->code_cat?>">Tout sélectionner</label>
                                <input class="chk-box-tout" type="checkbox" id="tout-<?=$categorie->code_cat?>" name="tout-<?=$categorie->code_cat?>" value="tout-<?=$categorie->code_cat?>">
                            </div>
                            <hr>
                        </div>

                        <!-- Liste des sous-catégories -->
                        <?php foreach ($categorie->getAllSousCat() as $key => $sousCat): ?>
                        <div class="sous-categorie" for="<?= $sousCat->libelle ?>">
                            <label for="<?= $sousCat->libelle ?>" class=".sous-categorie-catalogue"><?= $sousCat->libelle ?></label>
                            <input name="<?= $sousCat->libelle ?>" type="checkbox" id="<?= $sousCat->libelle ?>" name="sous-categorie">
                        </div>
                        <?php if($key != array_key_last($categorie->getAllSousCat())): ?> <hr> <?php endif; ?>
                        <?php endforeach;?>
                    </details>
                <?php endforeach;?>
                </div>
                <section class="prix">
                    <label>Prix :</label>
                    <section class="price-range">
                        <input type="number" name="prix_min" id="prix_min" value="<?php if(isset($_GET["prix_min"])):echo $_GET["prix_min"]; else: echo $min_price; endif?>" min="<?= $min_price ?>" max="<?= $max_price - 1 ?>">
                        <div class="slider">
                            <div class="progress"></div>
                            <div class="range-input">
                            <input type="range" class="range-min" min="<?= $min_price ?>" max="<?= $max_price - 1 ?>"  value="<?php if(isset($_GET["prix_min"])):echo $_GET["prix_min"]; else: echo $min_price;endif?>" step="1">
                            <input type="range" class="range-max" min="<?= $min_price + 1 ?>" max="<?= $max_price ?>"  value="<?php if(isset($_GET["prix_max"])):echo $_GET["prix_max"]; else: echo $max_price; endif?>" step="1">
                        </div>
                        </div>
                        <input type="number" name="prix_max" id="prix_max" value="<?php if(isset($_GET["prix_max"])):echo $_GET["prix_max"]; else: echo $max_price; endif?>" min="<?= $min_price + 1 ?>" max="<?= $max_price ?>">
                    </section>
                </section>
                <button class="normal-button vert supprimer-filtre">Supprimer le(s) filtre(s)</button>
            </form>
        </div>
    </section>
    <section class="partie-produits">
        <div class="liste-produits">
        <?php foreach($prods as $prod): ?>
            <?= $cardProduit->display($prod)?>
        <?php endforeach; ?>
        </div>
        <div class="nav-page">
            <button class="normal-button voir-plus  <?= ($estDernier)?"hidden":"" ?>">Voir plus</button>
        </div>
    </section>
</main>
<?php require("page_accueil/footer.php"); ?>
<script>
    cataloguePrice();   
    boutonCliquable(
        document.querySelector(".mobile-ouvrir-filtres"),
        () => {
            switchEtatFiltre(document.querySelectorAll(".mobile-ouvrir-filtres, .partie-filtre"));
            window.scrollTo(0,0);
            }
        );

    boutonCliquable(
        document.querySelector(".fermer-filtre"),
        () => switchEtatFiltre(document.querySelectorAll(".mobile-ouvrir-filtres, .partie-filtre"))
        );

    selectAll();
        var upFilter = new filterUpdate(document.forms["filters"],
        document.querySelector(".champsRecherche"), 
        document.querySelector(".liste-produits"),
        document.querySelector(".supprimer-filtre"),
        document.querySelector(".voir-plus")
    );
</script>
