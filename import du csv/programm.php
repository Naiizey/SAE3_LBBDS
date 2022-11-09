<?php
$data = array();
//fonction import csv
function import_csv($file,$path = '')
{
    $handle = '';
    if(empty($path))
    {
        echo '|-passage au dossier courant <br>';
        $handle = fopen($file, "r");
    }
    else 
    {
        echo '|-passage au dossier '.$path .'<br>';
        $handle = fopen($path.$file, "r");
    }
    return $handle;
}

//fonction de lecture du fichier qui prend en parametre le handle du fichier et la ligne a lire (ou all pour tout lire)
function read_csv($handle,$lire = 'all')
{
    $retour = array();
    $row = 0;
    while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
        $num = count($data);
        if ($lire == 'all') {
            for ($c=0; $c < $num; $c++) {
                $retour[$row][$c] = $data[$c];
            }
        }
        else {
            if ($row == $lire) {
                for ($c=0; $c < $num; $c++) {
                    $retour[$row][$c] = $data[$c];
                }
            }
        }
        $row++;
    }
    return $retour;
}

//fonction qui vérifie l'entête (écrit dans le nom de la fonction)
function verify_entete($line)
{
    $verif_state = true;
    $missing = 0;
    $listmanquant = array();
    $listproche = array();
    $list = array('code_sous_cat','intitule_prod','prix_ht','prix_ttc','description_prod','lien_image_prod','publication_prod','stock_prod','moyenne_note_prod','seuil_alerte_prod','alerte_prod');  
    $line = str_replace(' ', '', $line);
    foreach ($list as $value) {
        if (!in_array($value, $line)) {
            $verif_state = false;
            $missing++;
            $listmanquant[] = $value;
            $min = 100;
            $idelem;
            //cherche le champ le plus proche syntaxiquement
            for ($i=0; $i < count($line); $i++) { 
                $lev = levenshtein($value, $line[$i]);
                if ($lev < $min) {
                    $min = $lev;
                    $idelem = $i;
                }
            }
            $listproche[] = $line[$idelem];
        }
    }
    if ($verif_state) {
        echo '|-verification ok <br>';
    }
    else {
        echo 'verification échouée <br>';
        for ($i=0; $i < $missing; $i++) { 
            echo '|-champ manquant : '.$listmanquant[$i].' <br>';
            echo '|-champ le plus proche : '.$listproche[$i].' <br>';
        }
    }
    return $verif_state;
}

function convert_tab($tab)
{
    $errors = 0;
    $new_table = array();
    //on itère sur chaque tableau
    for ($i=0; $i < count($tab); $i++) { 
        //on itère sur chaque ligne
        if (count($tab[0]) == count($tab[$i]))
        {
            //on change les clés du tableau par les valeures de l'entête
            for ($j=0; $j < count($tab[0]); $j++) {
                $new_table[$i][$tab[0][$j]] = $tab[$i][$j];
            }
        }
        else {
            $errors++;
            echo '<br>|-erreur de formatage de la ligne '.$i;
        }
    }
    echo '<br>|-traitement ';
    if ($errors == 0) {
        echo 'ok <br>';
    }
    else {
        echo $errors.' erreur(s) détectée(s) <br>';
    }
    //export en json pour test (optionnel)
    $json = json_encode($new_table);
    $file = 'data.json';
    file_put_contents($file, $json);
    return $new_table;
}
// regex qui repond a l'expression : "code_sous_cat":"*" (avec * = n'importe quoi)

?>