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
            <div class="divCredit">
                <div class="sectionCredit">
                    <h2>Inscription</h2>
                    <?= afficheErreurs($erreurs, 'redirection'); ?>
                    <form action='<?= current_url() ?>' method="post">
                        <div class="nomPrenom">
                            <div>
                                <label for="nom">Nom<span class="requis">*</span> :</label>
                                <input type="text" name="nom" required="required" value="<?= $nom?>"/>
                            </div>
                            <div>
                                <label for="prenom">Prénom<span class="requis">*</span> :</label>
                                <input type="text" name="prenom" required="required" value="<?= $prenom?>"/>
                            </div>
                        </div>
                        <div class="infoRue">
                            <div>
                                <label for="numero_rue">Num rue<span class="requis">*</span> :</label>
                                <input type="text" name="numero_rue" required="required" value="<?= $numeroRue?>"/>
                            </div>
                            <div>
                                <label for="nom_rue">Nom rue<span class="requis">*</span> :</label>
                                <input type="text" name="nom_rue" required="required" value="<?= $nomRue?>"/>
                            </div>
                        </div>
                        <div class="infoVille">
                            <label for="code_postal">Code Postal<span class="requis">*</span> :</label>
                            <input type="text" name="code_postal" required="required" value="<?= $codePostal?>"/>
                    
                            <label for="ville">Ville<span class="requis">*</span> :</label>
                            <input type="text" name="ville" required="required" value="<?= $ville?>"/>
                        </div>
                        <label for="c_adresse1">Complément adresse 1 :</label>
                        <input type="text" name="c_adresse1"  value="<?= $cAdresse1?>"/>
                        <label>Complément adresse 2 :</label>
                        <input type="text" name="c_adresse2"  value="<?= $confirmezMotDePasse?>"/>
                        <label>Informations complémentaires :</label>
                        <textarea name="confirmezMotDePasse"  value="<?= $confirmezMotDePasse?>"/>
                        <input type="submit" value="Confirmer"/>
                    </form>
                    <a href="<?= base_url() ?>/connexion">J'ai déjà un compte</a>
                </div>
            </div>
        </main>
<?php require("footer.php"); ?>