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
        <main>
            <div class="divAlizon">
                <img src="<?= base_url() ?>/images/logo_noir.png" alt="logoAlizon" title="Accueil">
            </div>
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Connexion</h2>
                    <form action="<?= current_url() ?>" method="post">
                        <?= afficheErreurs($erreurs,'redirection'); ?>
                        <label>Identifiant ou adresse mail<span class="requis">*</span> :</label>
                        <input type="text" name="identifiant" required="required" value="<?= $identifiant?>"/>
                        <label>Mot de passe<span class="requis">*</span> : </label>
                        <input type="password" name="motDePasse" required="required" value="<?= $motDePasse?>"/>
                        <div class="divSouvenir">
                            <input type="checkbox"/>
                            <label>Se souvenir de moi</label>
                        </div>
                        <?= afficheErreurs($erreurs, 0) . afficheErreurs($erreurs, 1) ?>
                        <input type="submit" value="Se connecter"/>
                    </form>
                </div>
            </div>
        </main>
<?php require("footer.php"); ?>