<?php require("page_accueil/header.php"); ?>


<main id=Catalogue>
    <button class="mobile-ouvrir-filtres">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5v-2zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2h-11z"/>
                </svg>
                Filtres
            </h2>
    </button>
    <section class="partie-produits">
        <div class="liste-produits">
        <?php for($i=$minProd;$i<$maxProd && $i<sizeof($prods);++$i): ?>
            <?= $cardProduit->display($prods[$i])?>
        <?php endfor; ?>
        </div>
        <div class="nav-page">
            <div class="avant-current-page">
            <?php for($i=1;$i<=$nombreMaxPages;++$i): ?>
                        
                    <?php if($i==$page):?>
                        </div>
                        <div class="current-page">
                        <a <?=($i>1)?"href='".base_url()."/catalogue/".($i-1)."'":"" ?>  class="fleche-page <?=($i<=1)?"indisponible":"disponible" ?>"><?php include("./images/catalogue/Fleche_page_gauche.svg")?></a>
                        <span><?= $i ?> </span>
                        <a  <?=($i<$nombreMaxPages)?"href='".base_url()."/catalogue/".($i+1)."'":"" ?> class="fleche-page <?=($i>=$nombreMaxPages)?"indisponible":"disponible" ?>"><?php include("./images/catalogue/Fleche_page_droite.svg")?></a>
                        </div>
                        <div class="apres-current-page">
                    <?php else:?>
                        <?= $i ?>
                    <?php endif;?>
                    
                    
                    
            <?php endfor;?>
            </div>
        </div>
    </section>
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

        <div class="categorie-catalogue">
        <?php foreach ($categories as $categorie):?>
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
    </section>

</main>

<?php require("page_accueil/footer.php"); ?>
<script>

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
    
</script>