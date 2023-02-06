<?php require("header.php");?>
        <main>
            <div class="divAlizon">
                <img src="<?= base_url() ?>/images/logo_noir.png" alt="logoAlizon" title="Accueil">
            </div>
            <div class="divCredit">
                <section class="sectionCredit">
                    <div>
                        <h2>Mot de passe oublié</h2>
                        <form action="<?= base_url() ?>/obtenirCode" method="post">
                            <label class="labelRecupMail">Entrez votre adresse mail<span class="requis">*</span> :</label>
                            <div class="divRecupMail">
                                <input type="email" name="email" required="required" value="<?= $email?>"/>
                                <input type="submit" value="Obtenir code"/>
                            </div>
                            <?= "<div class='bloc-erreurs'>" ?>
                            <?php if (isset($retour[0])): ?>
                                <p class='paragraphe-valid'><?= $retour[0] ?>
                            <?php elseif (isset($retour[1])): ?>
                                <p class='paragraphe-erreur'><?= $retour[1] ?>
                            <?php endif; ?>
                            <?= "</p></div>" ?>
                        </form>
                    </div>
                    <div>
                        <form action="<?= base_url() ?>/validerCode" method="post">
                            <label>Entrez le code de récupération :</label>
                            <input type="text" name="code" required="required" value="<?= $code?>"/>
                            <?= "<div class='bloc-erreurs'>" ?>
                            <?php if (isset($retour[3])): ?>
                                <p class='paragraphe-valid'><?= $retour[3] ?>
                            <?php elseif (isset($retour[4])): ?>
                                <p class='paragraphe-erreur'><?= $retour[4] ?>
                            <?php endif; ?>
                            <?= "</p></div>" ?>
                            <input type="submit" value="Valider"/>
                        </form>
                        <a href="<?= base_url() ?>/connexion">Je me souviens de mon mot de passe</a>
                    </div>
                </section>
            </div>
        </main>
<?php require("footer.php"); ?>