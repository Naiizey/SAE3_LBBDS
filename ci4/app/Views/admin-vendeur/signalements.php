<?php require __DIR__ . "/../header.php";?>
    <main>
        <div class="divLst">
            <?php if(!empty($signalements)): ?>
                <table class='tableLst'>
                    <thead>
                        <tr>
                            <th>N° signalement</th>
                            <th>Raison</th>
                            <th>N° avis</th>
                            <th>N° compte</th>
                            <th>N° produit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($signalements); $i++): ?>
                            <tr class='lignesSignalements'>
                                <td><?= $signalements[$i]->id_signal ?></td>
                                <td><?= $signalements[$i]->raison ?></td>
                                <td class='numAvis'><?= $signalements[$i]->num_avis ?></td>
                                <td><?= $signalements[$i]->num_compte ?></td>
                                <td class='numProduit'><?= $produitSignalements[$i] ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Aucune signalement n'a été réalisé pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
<?php require __DIR__ . "/../footer.php";?>
<script>
    lstSignalements();
</script>