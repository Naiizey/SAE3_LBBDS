<?php require __DIR__ . "/../header.php";
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
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Inscription</h2>
                    <?= afficheErreurs($erreurs, 'redirection'); ?>
                    <form action='<?= current_url() ?>' method="post">
                        <label>Pseudo<span class="requis">*</span> :</label>
                        <input type="text" name="pseudo" required="required" value="<?= $pseudo?>"/>
                        <?=
                            afficheErreurs($erreurs, 3) .
                            afficheErreurs($erreurs, 8)
                        ?>
                        <div class="nomPrenom">
                            <div>
                                <label>Nom<span class="requis">*</span> :</label>
                                <input type="text" name="nom" required="required" value="<?= $nom?>"/>
                            </div>
                            <div>
                                <label>Prénom<span class="requis">*</span> :</label>
                                <input type="text" name="prenom" required="required" value="<?= $prenom?>"/>
                            </div>
                        </div>
                        <?= afficheErreurs($erreurs, 2); ?>
                        <label>Adresse mail<span class="requis">*</span> :</label>
                        <input type="email" name="email" required="required" value="<?= $email?>"/>
                        <?=
                            afficheErreurs($erreurs, 4) .
                            afficheErreurs($erreurs, 7)
                        ?>
                        <label>Mot de passe<span class="requis">*</span> :</label>
                        <input type="password" name="motDePasse" required="required" value="<?= $motDePasse?>"/>
                        <?=
                            afficheErreurs($erreurs, 5) .
                            afficheErreurs($erreurs, 6)
                        ?>
                        <label>Confirmez mot de passe<span class="requis">*</span> :</label>
                        <input type="password" name="confirmezMotDePasse" required="required" value="<?= $confirmezMotDePasse?>"/>
                        <?= afficheErreurs($erreurs, 1) ?>
                        <input type="submit" value="S'inscrire"/>
                    </form>
                    <a href="<?= base_url() ?>/connexion">J'ai déjà un compte</a>
                </div>
            </div>
        </main>
<?php require __DIR__ . "/../footer.php"; ?>