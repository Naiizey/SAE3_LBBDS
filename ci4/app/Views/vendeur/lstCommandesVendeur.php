<?php require("header.php"); ?>
    <main>
        <div class="divLst">
            <?php if(!empty($commandesVend)): ?>
                <table class="tableLst">
                    <thead>
                        <tr>
                            <th>N° commande</th>
                            <th>N° client</th>
                            <th>Date commande</th>
                            <th>Date livraison</th>
                            <th>Total HT</th>
                            <th>Total TTC</th>
                            <th>Etat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandesVend as $commandeVend): ?>
                            <tr class='lignesCommandes'>
                            <td class='numCommandes'><?= $commandeVend->num_commande ?></td>
                            <td><?= $commandeVend->num_compte ?></td>
                            <td><?= $commandeVend->date_commande ?></td>
                            <td><?= $commandeVend->date_arriv ?></td>
                            <td><?= $commandeVend->ht ?></td>
                            <td><?= $commandeVend->ttc ?></td>
                            <td><?= $commandeVend->etatString() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Aucune commande n'a été réalisée pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
<?php require("footer.php");?>
<script>
    lstCommandesVendeur();
</script>