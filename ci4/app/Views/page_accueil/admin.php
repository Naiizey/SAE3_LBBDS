<?php require("header.php"); ?>
        <main>
            <div class="divCredit">
                <section class="sectionCredit sectionAdmin">
                    <h2>Administration</h2>
                    <div>
                        <h3>Gestion de comptes</h3>
                        <a href="<?= base_url() ?>/espaceClient/admin/1">Modifier un compte</a>
                        <a>Supprimer un compte</a>
                        <h3>Bannissements</h3>
                        <a>Bannir temporairement un utilisateur</a>
                        <a>Bannir définitivement un utilisateur</a>
                        <a>Annuler un bannissement</a>
                        <h3>Commentaires signalés</h3>
                        <a>Voir les signalements</a>
                        <a>Supprimer des signalements </a>
                        <h3>Avertissements</h3>
                        <a>Avertir un utilisateur</a>
                        <a>Annuler un avertissement</a>
                    </div>
                </section>
            </div>
        </main>
<?php require("footer.php"); ?>