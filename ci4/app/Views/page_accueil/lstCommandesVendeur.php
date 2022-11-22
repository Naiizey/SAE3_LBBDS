<?php require("header.php");?>
    <main>
        <div id="divLstCommandes">
            <table id="tableLstCommandes">
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
                    <?php foreach ($commandesVend as $commandeVend){
                        echo "<tr class='lignesCommandes' >
                            <td class='numCommandes'>$commandeVend->num_commande</td>
                            <td>$commandeVend->num_compte</td>
                            <td>$commandeVend->date_commande</td>
                            <td>$commandeVend->date_arriv</td>
                            <td>$commandeVend->ht</td>
                            <td>$commandeVend->ttc</td>
                            <td>$commandeVend->etat</td>
                        </tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </main>
<?php require("footer.php");?>