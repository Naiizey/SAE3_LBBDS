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
                    <?php if(isset($controller) && $controller==="paiement"): ?>
                    <div class="onglet">
                        <h3>Adresses sauvegardées</h3>
                    </div>
                    <div class="onglet onglet-selectionnee">
                        <h3>Autre adresse</h3>
                    </div>
                    <?php elseif(isset($controller) && $controller==="infoLivraison"): ?>
                        <div class="onglet">
                            <h3>Adresses sauvegardées</h3>
                        </div>
                        <div class="onglet onglet-selectionnee">
                            <h3>Autre adresse</h3>
                        </div>
                        <div class="onglet">
                            <h3>Point relais</h3>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="sectionCredit">
                    <h2><?= (isset($controller) && $controller==="infoLivraison")?"Adresse livraison":"Adresse facture" ?></h2>
                  
                    <form action='<?= current_url() ?>' method="post" name="form_adresse">
                        <div class="surNomPrenom">
                            <div>
                                <input type="checkbox" name="utilise_nom_profil" <?= ($profil_utilisee)?"checked":"" ?> >
                                <label for="utilise_nom_profil">Utiliser les identifiants de mon compte</label>
                            </div>
                        <div class="nomPrenom">
                            <div>
                                <label for="nom">Nom :</label>
                                <input type="text" name="nom" required="required" sauvegardee=<?= $client->nom ?> value="<?= $adresse->nom ?>" <?= ($profil_utilisee)?"readOnly":"" ?>>
                            </div>
                            <div>
                                <label for="prenom">Prénom :</label>
                                <input type="text" name="prenom" required="required" sauvegardee=<?= $client->prenom ?> value="<?= $adresse->prenom  ?>"  <?= ($profil_utilisee)?"readOnly":"" ?>/>
                            </div>
                        </div>
                        </div>
                        

                        <div class="infoRue">
                            <div>
                                <label for="numero_rue">Numéro rue :</label>
                                <input type="text" name="numero_rue" required="required" value="<?= $adresse->numero_rue  ?>"/>
                                <?= $errors->showError("numero_rue","paragraphe_erreur") ?>
                            </div>
                            <div>
                                <label for="nom_rue">Nom rue :</label>
                                <input type="text" name="nom_rue" required="required" value="<?= $adresse->nom_rue ?>"/>
                                <?= $errors->showError("nom_rue","paragraphe_erreur") ?>
                            </div>
                        </div>

                        <div class="infoVille">
                            <div>
                                <label for="code_postal">Code Postal :</label>
                                <input list="code_postal_trouvee" type="text" name="code_postal" required="required"  pattern="[0-9]{5,6}" autocomplete="off" value="<?= $adresse->code_postal ?>"/>
                                <?= $errors->showError("code_postal","paragraphe_erreur") ?>
                            </div>
                            <div>                       
                                <label for="ville">Ville :</label>
                                <input list="ville_trouvee" type="text" name="ville" required="required" autocomplete="off" value="<?= $adresse->ville ?>"/>
                                <?= $errors->showError("ville","paragraphe_erreur") ?>
                                <datalist id="ville_trouvee">
                                </datalist>  
                            </div>
                        </div>

                        <label for="c_adresse1">Complément adresse 1 :</label>
                        <input type="text" name="c_adresse1"  value="<?= $adresse->c_adresse1 ?>"/>
                        <?= $errors->showError("comp_a1","paragraphe_erreur") ?>
             
                        <label>Complément adresse 2 :</label>
                        <input type="text" name="c_adresse2"  value="<?= $adresse->c_adresse2 ?>"/>
                        <?= $errors->showError("comp_a2","paragraphe_erreur") ?>
                        <?php if(isset($controller) && $controller==="infoLivraison"): ?>
                        
                        <label>Informations complémentaites :</label>
                        <textarea name="info_comp"><?= $adresse->infos_comp ?></textarea>

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
<script>
    var js = new formAdresseConstructor();
</script>