<!-- faire liens -->
<!--dans le imput de recherche : onkeyup="fonction de recherche en php"-->
<!-- ajuster les logos -->
<?php require __DIR__ . "/header.php";  ?>
<script></script>
                <main>
                        <div id="dropzone">
                                <p>Déposer un fichier csv dans cette zone<p>
                                <?= form_open_multipart('vendeur/import/upload') ?>
                                <input type="file" name="file" id="file" accept=".csv">
                                <input id="submit" type="submit" name="import" value="Importer" disabled/>
                        </div>
                        <div id="preview"></div>
                </main>
<?php require __DIR__ . "/footer.php"; ?>
<script>
        dragNDrop();
        checkCSV();
</script>