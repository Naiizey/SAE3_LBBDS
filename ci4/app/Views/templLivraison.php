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
            <?php require("formAdresse.php"); ?>
<?php require("footer.php"); ?>
<script>
    var js = new formAdresseConstructor();
</script>
