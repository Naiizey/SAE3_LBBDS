<?php require("header.php"); ?>
        </header>
        <main>
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Inscription</h2>
                    <form action='<?= base_url() ?>/inscription' method="post">
                        <label>Pseudo:</label>
                        <input type="text" name="pseudo" required="required"/>
                        <div class="nomPrenom">
                            <div>
                                <label>Nom:</label>
                                <input type="text" name="nom" required="required"/>
                            </div>
                            <div>
                                <label>Prénom:</label>
                                <input type="text" name="prenom" required="required"/>
                            </div>
                        </div>
                        <label>Adresse mail:</label>
                        <input type="email" name="email" required="required"/>
                        <label>Mot de passe:</label>
                        <input type="password" name="motDePasse" required="required"/>
                        <label>Confirmez mot de passe:</label>
                        <input type="password" name="confirmezMotDePasse" required="required"/>
                        <input type="submit" value="S'inscrire"/>
                    </form>
                    <a href="<?= base_url() ?>/connexion">J'ai déjà un compte</a>
                </div>
            </div>
        </main>
<?php require("footer.php"); ?>