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
                    <h2>Paiement</h2>
                    <form action="<?= current_url() ?>" method="post">
                        <label>Nom de la carte bancaire<span class="requis">*</span> :</label>
                        <input type="text" name="nomCB" required="required" value="<?= $nomCB?>"/>
                        <label class="labelCB">Numéro de votre carte bancaire<span class="requis">*</span> :</label>
                        <div class="conteneurCB">
                            <?php include(dirname(__DIR__,3)."/public/images/header/paiement.svg")?>
                            <input type="text" name="numCB" required="required" value="<?= $numCB?>"/>
                        </div>
                        <?= afficheErreurs($erreurs, 2) ?>
                        <div class="nomPrenom">
                            <div>
                                <label>Date d'expiration<span class="requis">*</span> :</label>
                                <input type="text" placeholder="mm/aa" pattern=".*/.*" name="dateExpiration" required="required" value="<?= $dateExpiration?>"/>
                            </div>
                            <div>
                                <label>Cryptogramme visuel<span class="requis">*</span> :</label>
                                <input type="text" pattern="[0-9][0-9][0-9]" name="CVC" required="required" value="<?= $CVC?>"/>
                            </div>
                        </div>
                        <?= 
                            afficheErreurs($erreurs, 0) . 
                            afficheErreurs($erreurs, 1) .
                            afficheErreurs($erreurs, 3) .
                            afficheErreurs($erreurs, 4)
                        ?>
                        <input type="submit" value="Continuer"/>
                    </form>
                </div>
            </div>
        </main>

<?php require("footer.php"); ?>