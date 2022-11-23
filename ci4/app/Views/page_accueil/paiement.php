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
                        <input type="text" name="nomCarte" required="required"/>
                        <label>N° de la carte : </label>
                        <input type="text" name="numCarte" required="required" class="test"/>
                        <input type="submit" value="Continuer"/>
                    </form>
                </div>
            </div>
        </main>

<?php require("footer.php"); ?>