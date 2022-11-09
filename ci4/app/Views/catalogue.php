<?php require("page_accueil/header.php"); ?>
<main id=Catalogue>
    <section class="partie-produits">
        <div class="liste-produits">
        <?php for($i=$minProd;$i<$maxProd && $i<sizeof($prods);++$i): ?>
            <?= $cardProduit->display($prods[$i])?>
        <?php endfor; ?>
        </div>
        <div class="nav-page">
            <?php for($i=0;$i<=$nombreMaxPages;++$i): ?>
                
                    <?php if($i==$page):?>
                        <a <?=($i>0)?"href='".base_url()."/catalogue/".($i-1)."'":"" ?>  class="fleche-page <?=($i<=1)?"indisponible":"" ?>"><img src='<?= base_url() ?>/images/catalogue/Fleche_page_gauche.svg' alt='tourner page vers la gauche'></a>
                        <span class="chiffre-page"><?= $i ?> </span>
                        <a  <?=($i<$nombreMaxPages)?"href='".base_url()."/catalogue/".($i+1)."'":"" ?> class="fleche-page <?=($i>=$nombreMaxPages)?"indisponible":"" ?>"><img class="fleche-page <?=($i==$nombreMaxPages)?"indisponible":"" ?>" src='<?= base_url() ?>/images/catalogue/Fleche_page_droite.svg' alt='tourner page vers la droite'></a>
                    <?php else:?>
                        <?= $i ?>
                    <?php endif;?>
               
            <?php endfor;?>
        </div>
    </section>
    <section class="partie-categorie">
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
    </section>

</main>
<?php require("page_accueil/footer.php"); ?>