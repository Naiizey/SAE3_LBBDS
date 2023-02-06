<?php require("header.php"); ?>
    <main>
        <div class="divLst">
            <?php if(!empty($bannissements)): ?>
                <table class='tableLst'>
                    <thead>
                        <tr>
                            <th>N° bannissement</th>
                            <th>N° compte</th>
                            <th>Raison</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Annuler le bannissement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < count($bannissements); $i++): ?>  
                            <tr class='lignesBannissements'>
                                <td><?= $bannissements[$i]->id_sanction ?></td>
                                <td><?= $bannissements[$i]->num_compte ?></td>
                                <td><?= $bannissements[$i]->raison ?></td>
                                <td><?= $bannissements[$i]->date_debut." ".$bannissements[$i]->heure_debut ?></td>
                                <td><?= $bannissements[$i]->date_fin." ".$bannissements[$i]->heure_fin ?></td>
                                <td>
                                    <form action="<?= current_url() ?>" method="post">
                                        <input type="hidden" name="id_bannissement" value="<?= $bannissements[$i]->id_sanction ?>">
                                        <button type="submit" class="buttonSanction"></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <h2>Aucun bannissement n'a été réalisé pour le moment.</h2>
            <?php endif; ?>
        </div>
    </main>
<?php require("footer.php");?>