<?php require("header.php");?>
        </header>
        <main>
            <div class="divAlizon">
                <img src="<?= base_url() ?>/images/logo_noir.png" alt="logoAlizon" title="Accueil">
            </div>
            <div class="divCredit">
                <section class="sectionCredit">
                    <div>
                        <h2>Mot de passe oublié</h2>
                        <form action="<?= base_url() ?>/obtenirCode" method="post">
                            <label class="labelRecupMail">Entrez votre adresse mail<span class="requis">*</span> :</label>
                            <div class="divRecupMail">
                                <input type="email" name="email" required="required" value="<?= $email?>"/>
                                <input type="submit" value="Obtenir code"/>
                            </div>
                            <?php
                                echo "<div class='bloc-erreurs'>";
                                if (isset($retour[0])) 
                                {
                                    echo "<p class='paragraphe-valid'>" . $retour[0]; 
                                }
                                else if (isset($retour[1]))
                                {
                                    echo "<p class='paragraphe-erreur'>" . $retour[1];
                                }
                                echo "</p></div>";
                            ?>
                        </form>
                    </div>
                    <div>
                        <form action="<?= base_url() ?>/validerCode" method="post">
                            <label>Entrez le code de récupération :</label>
                            <input type="text" name="code" required="required" value="<?= $code?>"/>
                            <?php
                                echo "<div class='bloc-erreurs'>";
                                if (isset($retour[3])) 
                                {
                                    echo "<p class='paragraphe-valid'>" . $retour[3]; 
                                }
                                else if (isset($retour[4]))
                                {
                                    echo "<p class='paragraphe-erreur'>" . $retour[4];
                                }
                                echo "</p></div>";
                            ?>
                            <input type="submit" value="Valider"/>
                        </form>
                        <a href="<?= base_url() ?>/connexion">Je me souviens de mon mot de passe</a>
                    </div>
                </section>
            </div>
        </main>
<?php require("footer.php"); ?>