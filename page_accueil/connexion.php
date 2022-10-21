<?php require("header.php"); ?>
        </header>
        <main>
            <section>
                <h2>Connexion</h2>
                <img src="./images/logo.png" alt="logoAlizon" title="Accueil" class="logoAlizon">
                <form action="credits.php" method="post">
                    <label>Nom d'utiliseur ou adresse mail:</label>
                    <input type="text" name="identifiant" required="required"/>
                    <label>Mot de passe: </label>
                    <input type="password" name="motDePasse" required="required"/>
                    <input type="checkbox" name="souvenirMoi"/>
                    <label>Se souvenir de moi</label>
                    <input type="submit" value="Valider"/>
                </form>
                <a href="incription.php">Je n'ai pas de compte</a>
            </section>
            <a href="">Mot de passe oublié ?</a>
        </main>
<?php require("footer.php"); ?>