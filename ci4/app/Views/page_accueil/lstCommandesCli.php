<?php require("header.php");?>
    <main>
        <div id="divLstCommandes">
            <?php if(!empty($commandesCli)){
                echo "<table id='tableLstCommandes'>
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
                    <tbody>";
                        foreach ($commandesCli as $commandeCli){
                        echo "<tr class='lignesCommandes'>
                            <td class='numCommandes'>$commandeCli->num_commande</td>
                            <td>$commandeCli->date_commande</td>
                            <td>$commandeCli->date_arriv</td>
                            <td>$commandeCli->prix_ht</td>
                            <td>$commandeCli->prix_ttc</td>
                            <td>",$commandeCli->etatString(),"</td>
                        </tr>";
                        }
                    echo "</tbody>
                </table>";
            } else {
                echo "<h2>Aucune commande n'a été réalisé pour le moment.</h2>";
            }?>
        </div>
    </main>
<?php require("footer.php");?>
<script>
    var base_url = '<?= base_url() ?>';
    lstCommandes();
</script>