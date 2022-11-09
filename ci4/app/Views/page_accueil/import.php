<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require("header.php"); ?>

<main>
        <div id="dropzone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
                <p>Déposer un fichier csv dans cette zone<p>
        </div>
        <form method="post" name="import_form" action="import_validation.php">
                <input type="file" name="file" id="file" accept=".csv" onchange="loadFile(event)">
                <input type="submit" name="import" value="Importer"/>
        </form>
        <?php
        if (isset($_POST['file'])) {
                print_r($_POST['file']);
        }
?>
</main>

<?php require("footer.php"); ?>