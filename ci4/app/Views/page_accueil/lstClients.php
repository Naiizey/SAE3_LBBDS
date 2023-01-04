<?php require("header.php");?>
    <main>
        <div class="divLst">
            <?php if(!empty($clients)): ?>
                <table class="tableLst">
                    <thead>
                        <tr>
                            <th>N° client</th>
                            <th>Identifiant</th>
                            <th>Sanctionner</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr class='lignesClients'>
                                <td class='numClients'><?= $client->numero ?></td>
                                <td><?= $client->identifiant ?></td>
                                <td>
                                    <button class="anchorClient"></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Il n'y a pas de clients pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
<?php require("footer.php");?>
<script>
    var current_url = "<?= current_url() ?>";
    lstClients();
</script>