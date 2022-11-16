<?php require("header.php");
    function afficheErreurs($e, $codeE)
    {
        if (isset($e[$codeE]))
        {
            return "<div class='bloc-erreurs'>
                                <p class='paragraphe-erreur'>$e[$codeE]</p>
                    </div>";
        }   
    }  
?>
        </header>
        <main>
            <div class="divAlizon">
                <img src="<?= base_url() ?>/images/logo_noir.png" alt="logoAlizon" title="Accueil">
            </div>
            <div class="divCredit sectionCredit">
                <div>
                    <h2>Mot de passe oublié</h2>
                    <form action="<?= base_url() ?>/mdpOublie" method="post">
                        <label class="labelRecupMail">Entrez votre adresse mail :</label>
                        <div class="divRecupMail">
                            <input type="text" name="mailRecup" required="required""/>
                            <input type="submit" value="Obtenir code"/>
                        </div>
                    </form>
                </div>
                <div>
                    <form action="<?= base_url() ?>/mdpOublie" method="post">
                        <label>Entrez le code de récupération :</label>
                        <input type="text" name="mailRecup" required="required""/>
                        <input type="submit" value="Valider"/>
                    </form>
                </div>
            </div>

        </main>
<?php require("footer.php"); ?>