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
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Connexion</h2>
                    <form action="<?= base_url() ?>/connexion" method="post">
                        <label>Nom d'utilisateur ou adresse mail:</label>
                        <input type="text" name="identifiant" required="required" value="<?= $identifiant?>"/>
                        <label>Mot de passe: </label>
                        <input type="password" name="motDePasse" required="required" value="<?= $motDePasse?>"/>
                        <div class="divSouvenir">
                            <input type="checkbox"/>
                            <label>Se souvenir de moi</label>
                        </div>
                        <?= afficheErreurs($erreurs, 0) . afficheErreurs($erreurs, 1) ?>
                        <input type="submit" value="Se connecter"/>
                    </form>
                    <a href="<?= base_url() ?>/inscription">Je n'ai pas de compte</a>
                </div>
                <a href="">Mot de passe oublié ?</a>
            </div>
        </main>
<?php require("footer.php"); ?>