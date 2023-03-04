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
<main class="mainProfil">
    <img src="<?= $logo ?>">
    <h2>Bonjour <?= $identifiant ?>!</h2>
    <div class="divCredit divProfil">
        <label class="noteAvis centreNoteProfil"><?= $noteVendeur ?><?= $note ?>/5</label>
        <section class="sectionCredit">
            <form name="formClient" action="<?= current_url() ?>" method="post">
                <label class="labelRecupMail">Texte de présentation</label>
                <div class="divInputEtLien">
                    <input type="text" name="texte_presentation" required="required" value="<?= $txtPres?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <?= afficheErreurs($erreurs, 8) ?>
                <label class="labelRecupMail">TVA intracommunautaire :</label>
                <div class="divInputEtLien">
                    <input type="text" name="tva_intercommunautaire" required="required" value="<?= $tvaIntraCom?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <?= afficheErreurs($erreurs, 2) ?>
                <label class="labelRecupMail">Numéro de SIRET :</label>
                <div class="divInputEtLien">
                    <input type="text" name="numero_siret" required="required" value="<?= $siret?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <label class="labelRecupMail">Votre identifiant :</label>
                <div class="divInputEtLien">
                    <input type="text" name="identifiant" required="required" value="<?= $identifiant?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <?= 
                    afficheErreurs($erreurs, 9) .
                    afficheErreurs($erreurs, 12) 
                ?>
                <label class="labelRecupMail">Adresse mail :</label>
                <div class="divInputEtLien">
                    <input type="email" name="email" required="required" value="<?= $email?>" disabled/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <?= 
                    afficheErreurs($erreurs, 7) .
                    afficheErreurs($erreurs, 11)
                ?>
                <label class="labelRecupMail labelAncienMdp"></label>
                <div class="divInputEtLien">
                    <input type="password" name="motDePasse" required="required" value="<?= $motDePasse?>" <?= $disableInput ?>/>
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"/></svg>
                    </a>
                </div>
                <?= afficheErreurs($erreurs, 3) ?>
                <label class="labelRecupMail <?= $classCacheDiv ?>">Confirmez votre ancien mot de passe</label>
                <div class="divInputEtLien <?= $classCacheDiv ?>">
                    <input type="password" name="confirmezMotDePasse" require="<?= $requireInput ?>" value="<?= $confirmezMotDePasse?>"/>
                </div>
                <?= afficheErreurs($erreurs, 6) ?>
                <label class="labelRecupMail <?= $classCacheDiv ?>">Entrez votre nouveau mot de passe</label>
                <div class="divInputEtLien <?= $classCacheDiv ?>">
                    <input type="password" name="nouveauMotDePasse" require="<?= $requireInput ?>" value="<?= $nouveauMotDePasse?>"/>
                </div>
                <?=
                    afficheErreurs($erreurs, 1) .
                    afficheErreurs($erreurs, 4) .
                    afficheErreurs($erreurs, 5)
                ?>
                <div class="divAdressesCli">
                    <div>
                        <h3>Votre adresse :</h3>
                        <ul>
                            <li>
                                <p>Numéro de rue : <?= $numRue ?></p>
                            </li>
                            <li>
                                <p>Nom de rue : <?= $nomRue ?></p>
                            </li>
                            <li>
                                <p>Ville : <?= $ville ?></p>
                            </li>
                            <li>
                                <p>Code postal : <?= $codePostal ?></p>
                            </li>
                            <li>
                                <p>Compléments : <?= $compA1 . ", " . $compA2 ?></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <input type="submit" value="Enregistrer"/>
            </form>
        </section>
    </div>
</main>
<?php require("footer.php"); ?>
<script>
    var js = new profilCli("admin");
</script>