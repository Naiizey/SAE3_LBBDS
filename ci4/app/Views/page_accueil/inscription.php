<?php require("header.php"); ?>
        </header>
        <main>
            <section>
                <h2>Inscription</h2>
                <form action="credits.php" method="post">
                    <label>Pseudo:</label>
                    <input type="text" name="pseudo" required="required"/>
                    <label>Nom:</label>
                    <input type="text" name="nom" required="required"/>
                    <label>Prénom:</label>
                    <input type="text" name="prenom" required="required"/>
                    <label>Adresse mail:</label>
                    <input type="email" name="email" required="required"/>
                    <label>Mot de passe:</label>
                    <input type="password" name="motDePasse" required="required"/>
                    <label>Confirmez mot de passe:</label>
                    <input type="password" name="confirmezMotDePasse" required="required"/>
                    <input type="submit" value="S'inscrire"/>
                </form>
                <a href="incription.php">J'ai déjà un compte</a>
            </section>
        </main>
<?php require("footer.php"); ?>