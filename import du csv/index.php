<?php
echo "début de l\'import :<br>";
include 'programm.php';
//import csv
$handle = import_csv('products.csv');

//read csv
echo 'détection/verification des champs :<br>';
$rstline = read_csv($handle);
//print_r($rstline[0]);
if (verify_entete($rstline[0])) {
    echo 'traitement des données :';
    convert_tab($rstline);
    echo 'fin du traitement';
}
else {
    echo '<br>verification échouée fin du programme <br>';
}
?>
