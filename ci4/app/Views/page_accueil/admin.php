<?php require("header.php"); ?>
        <main>
            <div class="divCredit">
                <section class="sectionCredit sectionAdmin">
                    <h2>Administration</h2>
                    <div>
                        <h3>Gestion de comptes</h3>
                        <a href="<?= base_url() ?>/admin/Clients">Voir les comptes clients</a>
                        <a>Supprimer un compte</a>
                        <h3>Bannissements</h3>
                        <a href="<?= base_url() ?>/admin/Clients/bannir">Bannir un client</a>
                        <a>Voir les bannissements</a>
                        <h3>Commentaires signalés</h3>
                        <a href="<?= base_url() ?>/admin/signalements">Voir les signalements</a>
                        <h3>Avertissements</h3>
                        <a>Avertir un utilisateur</a>
                        <a>Annuler un avertissement</a>
                    </div>
                </section>
            </div>
        </main>
<?php require("footer.php"); ?>