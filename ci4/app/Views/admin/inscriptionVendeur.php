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
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Créer un compte vendeur</h2>
                    <?= afficheErreurs($erreurs, 'redirection'); ?>
                    <form action='<?= current_url() ?>' method="post">
                        <label>Texte de présentation<span class="requis">*</span> :</label>
                        <input type="text" name="texte_presentation" required="required" value="<?= $txtPres?>"/>
                        <?=
                            afficheErreurs($erreurs, 9)
                        ?>
                        <label>TVA intercommunautaire<span class="requis">*</span> :</label>
                        <input type="text" name="tva_intercommunautaire" required="required" value="<?= $tvaInterCom?>"/>
                        <?=
                            afficheErreurs($erreurs, 2) .
                            afficheErreurs($erreurs, 13)
                        ?>
                        <label>Numéro de SIRET<span class="requis">*</span> :</label>
                        <input type="text" name="numero_siret" required="required" value="<?= $siret?>"/>
                        <?=
                            afficheErreurs($erreurs, 10)
                        ?>
                        <label>Identifiant<span class="requis">*</span> :</label>
                        <input type="text" name="identifiant" required="required" value="<?= $identifiant?>"/>
                        <?=
                            afficheErreurs($erreurs, 3) .
                            afficheErreurs($erreurs, 8)
                        ?>
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
                </div>
            </div>
        </main>
<?php require("footer.php"); ?>