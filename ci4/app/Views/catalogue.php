<?php require("header.php"); ?>
<?php model("\App\Models\ProduitCatalogue")->selectMax('prixttc')?>
<main id=Catalogue>
    <button class="bulle-ouvrir-filtres">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
        <h2>
            Filtres
        </h2>
    </button>
    <button class="bulle-ouvrir-tris">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M137.4 41.4c12.5-12.5 32.8-12.5 45.3 0l128 128c9.2 9.2 11.9 22.9 6.9 34.9s-16.6 19.8-29.6 19.8H32c-12.9 0-24.6-7.8-29.6-19.8s-2.2-25.7 6.9-34.9l128-128zm0 429.3l-128-128c-9.2-9.2-11.9-22.9-6.9-34.9s16.6-19.8 29.6-19.8H288c12.9 0 24.6 7.8 29.6 19.8s2.2 25.7-6.9 34.9l-128 128c-12.5 12.5-32.8 12.5-45.3 0z"/></svg>
        <h2>
            Tris
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
                            <input <?= ((isset($filters[$sousCat->libelle]) && $filters[$sousCat->libelle]=="on")?"checked":"") ?> name="<?= $sousCat->libelle ?>" type="checkbox" id="<?= $sousCat->libelle ?>">
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
    <section class="partie-tris">
        <div class="liste-tris">
            <div class="titre-tris">
                <h1>Tris</h1>
                <button class="fermer-tris">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                    </svg>
                </button>
            </div>
            <form name="tris" method="get">
                <input type="radio" name="trisB" id="nom" value="intitule" <?= ((isset($filters["trisB"])) && $filters["trisB"] || (!isset($filters["trisB"]) =="intitule")?"checked":"") ?> ><label for="nom"> Nom </label>
                <input type="radio" name="trisB" id="prix" value="prixttc" <?= ((isset($filters["trisB"]) && $filters["trisB"]=="prixttc")?"checked":"") ?> ><label for="prix"> Prix </label>
                <input type="radio" name="trisB" id="avis" value="moyennenote"  <?= ((isset($filters["trisB"]) && $filters["trisB"]=="moyennenote")?"checked":"") ?> ><label for="avis"> Avis </label>
                <br>
                <select name="Ordre" id="ordre">
                    <option value="ASC"> ↓ Croissant </option>
                    <option value="DESC"> ↑ Décroissant </option>
                </select>
            </form>
            </div>
    </section>
    <section class="partie-produits">
        <div class="liste-produits">
        <?php if(isset($prods) && !empty($prods)): ?>
            <?php foreach($prods as $prod): ?>
                <?= $cardProduit->display($prod)?>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <div class="nav-page">
            <button class="normal-button voir-plus  <?= ($estDernier)?"hidden":"" ?>">Voir plus</button>
        </div>
        <div class="bloc-erreur-liste-produit <?= (isset($message))?"":"hidden"; ?>">
                    <p class="paragraphe-erreur">
                        <?= (isset($message))?$message:"" ?>
                    </p>
        <div class="erreur-liste-produit">
    </section>
</main>
<?php require("footer.php"); ?>
<script>
    cataloguePrice();
    boutonCliquable(
        document.querySelector(".bulle-ouvrir-filtres"),
        () => {
            switchEtatFiltre(document.querySelectorAll(".bulle-ouvrir-filtres, .partie-filtre"));
            window.scrollTo(0,0);
            }
        );
    boutonCliquableTris(
        document.querySelector(".bulle-ouvrir-tris"),
        () => {
            switchEtatTris(document.querySelectorAll(".bulle-ouvrir-tris, .partie-tris"));
            window.scrollTo(0,0);
            }
        );

    boutonCliquableTris(
        document.querySelector(".fermer-tris"),
        () => switchEtatTris(document.querySelectorAll(".bulle-ouvrir-tris, .partie-tris"))
        );

    boutonCliquable(
        document.querySelector(".fermer-filtre"),
        () => switchEtatFiltre(document.querySelectorAll(".bulle-ouvrir-filtres, .partie-filtre"))
        );
    selectAll();
    var upFilter = new filterUpdate(document.forms["filters"],
        document.querySelector(".champsRecherche"),
        document.querySelector(".liste-produits"),
        document.querySelector(".supprimer-filtre"),
        document.querySelector(".voir-plus"),
        document.forms["tris"]
    );
    loadFiltersTris();
    changeOnglet();
</script>
