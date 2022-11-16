<?php require("header.php");?>
        </header>
        <main>
            <div class="divAlizon">
                <img src="<?= base_url() ?>/images/logo_noir.png" alt="logoAlizon" title="Accueil">
            </div>
            <div class="divCredit sectionCredit">
                <div>
                    <h2>Mot de passe oublié</h2>
                    <form action="<?= base_url() ?>/obtenirCode" method="post">
                        <label class="labelRecupMail">Entrez votre adresse mail :</label>
                        <div class="divRecupMail">
                            <input type="text" name="mailRecup" required="required""/>
                            <input type="submit" value="Obtenir code"/>
                        </div>
                        <?php
                            if (isset($retour)) {
                                echo $retour;
                            }
                        ?>
                    </form>
                </div>
                <div>
                    <form action="<?= base_url() ?>/validerCode" method="post">
                        <label>Entrez le code de récupération :</label>
                        <input type="email" name="email" required="required" value=""/>
                        <input type="submit" value="Valider"/>
                    </form>
                </div>
            </div>

        </main>
<?php require("footer.php"); ?>