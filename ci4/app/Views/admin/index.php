<?php require __DIR__ . "/header.php"; ?>
        <main>
            <div class="divCredit">
                <section class="sectionCredit sectionAdmin">
                    <h2>Administration</h2>
                    <h3>Gestion de comptes</h3>
                    <div>
                        <a href="<?= base_url() ?>/admin/clients">Voir les comptes clients</a>
                    </div>
                    <div>
                        <a href="<?= base_url() ?>/admin/vendeurs/inscription">Créer un compte vendeur</a>
                        <a href="<?= base_url() ?>/admin/vendeurs">Voir les comptes vendeurs</a>
                    </div>
                    <h3>Bannissements</h3>
                    <div>
                        <a href="<?= base_url() ?>/admin/clients/bannir">Bannir un client</a>
                        <a href="<?= base_url() ?>/admin/bannissements">Voir les bannissements</a>
                    </div>
                    <h3>Avis signalés</h3>
                    <div>
                        <a href="<?= base_url() ?>/admin/signalements">Voir les signalements</a>
                        <a href="<?= base_url() ?>/admin/avis">Voir les avis</a>
                    </div>
                    <h3>Avertissements</h3>
                    <div>
                        <a>Avertir un utilisateur</a>
                        <a>Annuler un avertissement</a>
                    </div>
                </section>
            </div>
        </main>
<?php  require __DIR__ . "/../footer.php"; ?>