<?php require("header.php"); ?>
    <main>
        <div class="divLst">
            <?php if(!empty($vendeurs)): ?>
                <table class="tableLst">
                    <thead>
                        <tr>
                            <th>N° compte</th>
                            <th>Identifiant</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vendeurs as $vendeur): ?>
                            <tr class='lignesVendeurs'>
                                <td class='numVendeur'><?= $vendeur->numero ?></td>
                                <td><?= $vendeur->identifiant ?></td>
                                <td>
                                    <a href="<?= base_url() . "/admin/vendeurs/" . $vendeur->numero ?>">
                                        <svg class="svgSupr" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg> 
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Il n'y a pas de vendeurs pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
<?php require("footer.php");?>
<script>
    lstVendeurs();
</script>