<main>
            <div class="divFormAdresse">
                <div class="onglets">
                        
                        
                        <a class="onglet <?= ($controller==="Facture")?"onglet-selectionnee":"" ?>" href="<?= base_url()."/facture" ?>">
                            <h3>Facture</h3>
                        </a>

                        <a class="onglet <?= ($controller==="Livraisons")?"onglet-selectionnee":"" ?>"  href="<?= base_url()."/livraison" ?>"> 
                            <h3>Livraison</h3>
                        </a>
                    
                    
                </div>
                <div class="sectionCredit">
                    <?php if(isset($dejaRempli)): ?>
                        <a class="deja-rempli-lien">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 12"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>                        
                                <?= " ".$dejaRempli?>
                            </span>
                        </a>
                    <?php endif ?>

                    <h2><?= (isset($controller) && $controller === "Livraisons")?"Adresse livraison":"Adresse facture" ?></h2>
                    <form action='<?= current_url() ?>' method="post" name="form_adresse">
                        <div class="surNomPrenom">
                            <div>
                                <input type="checkbox" name="utilise_nom_profil" <?= ($profil_utilisee)?"checked":"" ?> >
                                <label for="utilise_nom_profil">Utiliser les identifiants de mon compte</label>
                            </div>
                        <div class="nomPrenom">
                            <div>
                                <label for="nom">Nom<span class="requis">*</span> :</label>
                                <input type="text" name="nom"  maxlength="50" required="required" sauvegardee=<?= $client->nom ?> value="<?= $adresse->nom ?>" <?= ($profil_utilisee)?"readOnly":"" ?>>
                            </div>
                            <div>
                                <label for="prenom">Prénom<span class="requis">*</span> :</label>
                                <input type="text" name="prenom"  maxlength="50" required="required" sauvegardee=<?= $client->prenom ?> value="<?= $adresse->prenom  ?>"  <?= ($profil_utilisee)?"readOnly":"" ?>/>
                            </div>
                            
                        </div>
                            <?= $errors->showError("nom","paragraphe_erreur") ?>
                        
                            <?= ($errors->hasError("nom"))?"":$errors->showError("prenom","paragraphe_erreur") ?>
                            
                        </div>
                        

                        <div class="infoRue">
                            
                                <label class="colonne-numero-rue" for="numero_rue"><span>Numéro de rue<span class="requis">*</span> :</span></label>
                                <label class="colonne-nom-rue" for="nom_rue"><span>Nom de rue<span class="requis">*</span> :</span></label>
                                
                                <input class="colonne-numero-rue" type="text" name="numero_rue" required="required" value="<?= $adresse->numero_rue  ?>"/>
                                <input class="colonne-nom-rue" type="text" name="nom_rue" required="required" value="<?= $adresse->nom_rue ?>"/>
                                
                            
                            
                                
                                <div class="colonne-numero-rue position-erreur" for="numero_rue" ><?= $errors->showError("numero_rue","paragraphe_erreur") ?></div>
                                <div class="colonne-nom-rue position-erreur" for="nom_rue"><?= $errors->showError("nom_rue","paragraphe_erreur") ?></div>
                                
                            
                        </div>

                        <div class="infoVille">                      
                                <label class="colonne-code-postal" for="code_postal">Code Postal<span class="requis">*</span> :</label>
                                <label class="colonne-ville" for="ville">Ville<span class="requis">*</span> :</label>

                                <input class="colonne-code-postal" list="code_postal_trouvee" type="text" name="code_postal" required="required"  pattern="[0-9]{5,6}" autocomplete="off" value="<?= $adresse->code_postal ?>"/>
                                <input class="colonne-ville" list="ville_trouvee" type="text" name="ville" required="required" autocomplete="off" value="<?= $adresse->ville ?>"/>
                                
                                <div class="colonne-code-postal position-erreur" for="code_postal"><?= $errors->showError("code_postal","paragraphe_erreur") ?></div>
                                <div class="colonne-ville position-erreur" for="ville"><?= $errors->showError("ville","paragraphe_erreur") ?></div>
                                <datalist id="ville_trouvee">
                                </datalist>  
                            
                        </div>

                        <label for="c_adresse1">Complément adresse 1 :</label>
                        <input type="text" name="c_adresse1" maxlength=150 value="<?= $adresse->c_adresse1 ?>"/>
                        <?= $errors->showError("comp_a1","paragraphe_erreur") ?>
             
                        <label>Complément adresse 2 :</label>
                        <input type="text" name="c_adresse2"  maxlength=150 value="<?= $adresse->c_adresse2 ?>"/>
                        <?= $errors->showError("comp_a2","paragraphe_erreur") ?>
                        <?php if(isset($controller) && $controller === "Livraisons"): ?>
                        
                        <label>Informations complémentaires :</label>
                        <textarea name="info_comp" maxlength=250><?= $adresse->infos_comp ?></textarea>

                        <div class="sauvegarder-adresse">
                            <input type="checkbox" name="sauvegarder_adresse">
                            <label for="sauvegarder_adresse">Sauvegarder cette adresse</label>
                        </div>
        
                        
                        
                        <?php endif; ?>

                        <input type="submit" value="Confirmer"/>
                    </form>
                
                </div>
            </div>
        </main>