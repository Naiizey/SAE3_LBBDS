<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require("header.php"); ?>

<main>
        <div id="dropzone">
                <p>Déposer un fichier csv dans cette zone<p>
                <?= form_open_multipart('import/upload') ?>
                        <input type="file" name="file" id="file" accept=".csv">
                        <input type="submit" name="import" value="Importer"/>
        </div>
</main>

<?php require("footer.php"); ?>