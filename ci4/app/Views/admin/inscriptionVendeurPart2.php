<main>
            <div class="divFormAdresse">
                <div class="sectionCredit">
                    <form action='<?= current_url() ?>' method="post" name="form_adresse">
                        <div class="infoRue">
                                <label class="colonne-numero-rue" for="numero_rue"><span>Numéro de rue<span class="requis">*</span> :</span></label>
                                <label class="colonne-nom-rue" for="nom_rue"><span>Nom de rue<span class="requis">*</span> :</span></label>
                                <input class="colonne-numero-rue" type="text" name="numero_rue" required="required" value="<?= $numero_rue  ?>"/>
                                <input class="colonne-nom-rue" type="text" name="nom_rue" required="required" value="<?= $nom_rue ?>"/>
                                <div class="colonne-numero-rue position-erreur" for="numero_rue" ><?= $errors ?></div>
                                <div class="colonne-nom-rue position-erreur" for="nom_rue"><?= $errors ?></div>
                        </div>
                        <div class="infoVille">                      
                                <label class="colonne-code-postal" for="code_postal">Code Postal<span class="requis">*</span> :</label>
                                <label class="colonne-ville" for="ville">Ville<span class="requis">*</span> :</label>
                                <input class="colonne-code-postal" list="code_postal_trouvee" type="text" name="code_postal" required="required"  pattern="[0-9]{5,6}" autocomplete="off" value="<?= $code_postal ?>"/>
                                <input class="colonne-ville" list="ville_trouvee" type="text" name="ville" required="required" autocomplete="off" value="<?= $ville ?>"/>
                                <div class="colonne-code-postal position-erreur" for="code_postal"><?= $errors ?></div>
                                <div class="colonne-ville position-erreur" for="ville"><?= $errors ?></div>
                                <datalist id="ville_trouvee">
                                </datalist>  
                        </div>
                        <label for="c_adresse1">Complément adresse 1 :</label>
                        <input type="text" name="c_adresse1" maxlength=150 value="<?= $c_adresse1 ?>"/>
                        <?= $errors ?>
                        <label> Complément adresse 2 :</label>
                        <input type="text" name="c_adresse2"  maxlength=150 value="<?= $c_adresse2 ?>"/>
                        <?= $errors ?>
                        <input type="submit" value="Confirmer"/>
                    </form>
                </div>
            </div>
        </main>