<?php 
    require(dirname(__DIR__) .  "/header.php");
    function afficheErreurs($e, $codeE)
    {
        if (isset($e[$codeE]))
        {
            return "<div class='bloc-erreurs'>
                                <p class='paragraphe-erreur'>$e[$codeE]</p>
                    </div>";
        }   
    }  
    require("formAdresse.php");
    require(dirname(__DIR__) . "/footer.php");
?>
<script>
    var js = new formAdresseConstructor();
</script>
