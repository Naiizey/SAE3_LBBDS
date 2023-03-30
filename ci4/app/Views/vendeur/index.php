<?php require("header.php"); ?>
        <main>
            <div class="divCredit">
                <section class="sectionCredit sectionVendeur">
                    <h2>Fonctionnalités vendeur</h2>
                    <h3>Gestion de produits</h3>
                    <div>
                        <a href="<?= base_url() ?>/vendeur/import">Importer des produits</a>
                        <a href="<?= base_url() ?>/vendeur/catalogue">Catalogue</a>
                    </div>
                    <h3>Gestion des commandes</h3>
                    <div>
                        <a href="<?= base_url() ?>/vendeur/commandes">Voir les commandes client</a>
                    </div>
                </section>
            </div>
        </main>
<?php  require("footer.php"); ?>