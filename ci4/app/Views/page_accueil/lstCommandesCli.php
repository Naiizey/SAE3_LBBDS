<?php require("header.php");?>
    <main>
        <div id="divLstCommandes">
            <?php if(!empty($commandesCli)): ?>
                <table id='tableLstCommandes'>
                    <thead>
                        <tr>
                            <th>N° commande</th>
                            <th>Date commande</th>
                            <th>Date livraison</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Etat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandesCli as $commandeCli): ?>
                            <tr class='lignesCommandes'>
                            <td class='numCommandes'><?= $commandeCli->num_commande ?></td>
                            <td><?= $commandeCli->date_commande ?></td>
                            <td><?= $commandeCli->date_arriv ?></td>
                            <td><?= $commandeCli->prix_ht ?></td>
                            <td><?= $commandeCli->prix_ttc ?></td>
                            <td><?= $commandeCli->etatString() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Aucune commande n'a été réalisé pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
<?php require("footer.php");?>
<script>

    lstCommandes();
</script>