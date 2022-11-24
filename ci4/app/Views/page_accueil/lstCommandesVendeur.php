<?php require("header.php");?>
    <main>
        <div id="divLstCommandes">
            <?php if(!empty($commandesVend)){
                echo "<table id='tableLstCommandes'>
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
                    <tbody>";
                        foreach ($commandesVend as $commandeVend){
                        echo "<tr class='lignesCommandes'>
                            <td class='numCommandes'>$commandeVend->num_commande</td>
                            <td>$commandeVend->num_compte</td>
                            <td>$commandeVend->date_commande</td>
                            <td>$commandeVend->date_arriv</td>
                            <td>$commandeVend->ht</td>
                            <td>$commandeVend->ttc</td>
                            <td>",$commandeVend->etatString(),"</td>
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
    lstCommandes();
</script>