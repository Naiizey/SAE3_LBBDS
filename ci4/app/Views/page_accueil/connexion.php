<?php require("header.php"); ?>
        </header>
        <main>
            
            <div class="divAlizon">
                <img src="<?= base_url() ?>/images/logo_noir.png" alt="logoAlizon" title="Accueil">
            </div>
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Connexion</h2>
                    <form action="<?= base_url() ?>/credits/connexion" method="post">
                        <label>Nom d'utilisateur ou adresse mail:</label>
                        <input type="text" name="identifiant" required="required"/>
                        <label>Mot de passe: </label>
                        <input type="password" name="motDePasse" required="required"/>
                        <div class="divSouvenir">
                            <input type="checkbox"/>
                            <label>Se souvenir de moi</label>
                        </div>
                        <?=$error ?>
                        <input type="submit" value="Se connecter"/>
                    </form>
                    <a href="<?= base_url() ?>/inscription">Je n'ai pas de compte</a>
                </div>
                <a href="">Mot de passe oublié ?</a>
            </div>
        </main>
<?php require("footer.php"); ?>