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
                        <label>Nom de la carte :</label>
                        <input type="text" name="nomCarte" required="required" value="<?= $nomCB?>"/>
                        <label class="labelCB">N° de la carte : </label>
                        <div class="conteneurCB">
                            <?php include(dirname(__DIR__,3)."/public/images/header/paiement.svg")?>
                            <input type="text" name="numCarte" required="required" value="<?= $numCB?>"/>
                        </div>
                        <div class="nomPrenom">
                            <div>
                                <label>Date d'expiration :</label>
                                <input type="text" name="nomCarte" required="required" value="<?= $DateExpiration?>"/>
                            </div>
                            <div>
                                <label>Cryptogramme visuel :</label>
                                <input type="text" name="nomCarte" required="required" value="<?= $CCV?>"/>
                            </div>
                        </div>
                        <input type="submit" value="Continuer"/>
                    </form>
                </div>
            </div>
        </main>

<?php require("footer.php"); ?>