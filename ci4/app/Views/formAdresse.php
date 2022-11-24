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
            <div class="divFormAdresse">
                <div class="onglets">
                    <?php if(isset($controller) && $controller==="infoLivraison"): ?>
                    <div class="onglet">
                        <h3>Adresses sauvegardées</h3>
                    </div>
                    <div class="onglet onglet-selectionnee">
                        <h3>Autre adresse</h3>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="sectionCredit">
                    <h2><?= (isset($controller) && $controller==="infoLivraison")?"Adresse livraison":"Adresse facture" ?></h2>
                  
                    <form action='<?= current_url() ?>' method="post">
                        <div class="surNomPrenom">
                            <div>
                                <input type="checkbox" name="utilise_nom_profil">
                                <label for="utilise_nom_profil">Utiliser les identifiants de mon compte</label>
                            </div>
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
                        </div>
                        

                        <div class="infoRue">
                            <div>
                                <label for="numero_rue">Numéro rue :</label>
                                <input type="text" name="numero_rue" required="required" value="<?= "" ?>"/>
                            </div>
                            <div>
                                <label for="nom_rue">Nom rue :</label>
                                <input type="text" name="nom_rue" required="required" value="<?= "" ?>"/>
                            </div>
                        </div>

                        <div class="infoVille">
                            <div>
                                <label for="code_postal">Code Postal :</label>
                                <input type="text" name="code_postal" required="required" value="<?= ""?>"/>
                            </div>
                            <div>                       
                                <label for="ville">Ville :</label>
                                <input type="text" name="ville" required="required" value="<?= ""?>"/>  
                            </div>
                        </div>

                        <label for="c_adresse1">Complément adresse 1 :</label>
                        <input type="text" name="c_adresse1"  value="<?= ""?>"/>
             
                        <label>Complément adresse 2 :</label>
                        <input type="text" name="c_adresse2"  value="<?= ""?>"/>
                        <?php if(isset($controller) && $controller==="infoLivraison"): ?>
                        
                        <label>Informations complémentaites :</label>
                        <textarea name="info_comp"></textarea>

                        <div class="sauvegarder-adresse">
                            <input type="checkbox" name="sauvegarder_adresse">
                            <label for="sauvegarder_adresse">Sauvegarder cette adresse</label>
                        </div>
        
                        <input type="submit" value="Confirmer"/>
                        
                        <?php endif; ?>
                    </form>
                
                </div>
            </div>
        </main>
<?php require("page_accueil/footer.php"); ?>