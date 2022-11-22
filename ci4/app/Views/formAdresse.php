<?php require("page_accueil/header.php");
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
                  
                    <form action='<?= current_url() ?>' method="post">
                        
                        <div class="nomPrenom">
                            <div>
                                <label for="nom">Nom :</label>
                                <input type="text" name="nom" required="required" value="<?= "" ?>"/>
                            </div>
                            <div>
                                <label for="prenom">Prénom :</label>
                                <input type="text" name="prenom" required="required" value="<?= "" ?>"/>
                            </div>
                        </div>

                        <div class="infoRue">
                            <div>
                                <label for="numero_rue">Numéro   rue :</label>
                                <input type="text" name="numero_rue" required="required" value="<?= "" ?>"/>
                            </div>
                            <div>
                                <label for="nom_rue">Nom rue :</label>
                                <input type="text" name="nom_rue" required="required" value="<?= "" ?>"/>
                            </div>
                        </div>

                        <div class="infoVille">
                            <label for="code_postal">Code Postal :</label>
                            <input type="text" name="code_postal" required="required" value="<?= ""?>"/>
                    
                            <label for="ville">Ville :</label>
                            <input type="text" name="ville" required="required" value="<?= ""?>"/>
                        </div>

                        <label for="c_adresse1">Complément adresse 1 :</label>
                        <input type="text" name="c_adresse1"  value="<?= ""?>"/>
             
                        <label>Complément adresse 2 :</label>
                        <input type="text" name="c_adresse2"  value="<?= ""?>"/>

                        <label>Informations complémentaites :</label>
                        <textarea name="info_comp"  value="<?= ""?>">
                        </textarea>
        
                        <input type="submit" value="Confirmer"/>
                    </form>
                
                </div>
            </div>
        </main>
<?php require("page_accueil/footer.php"); ?>