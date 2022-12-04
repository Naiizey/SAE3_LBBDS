<?php namespace App\Controllers;

use Exception;
use CodeIgniter\Files\File;

class Import extends BaseController
{
    protected $helpers = ['form', 'filesystem'];
    
    public function __construct()
    {
        helper('cookie');
        if (session()->has("numero")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
        } else if (has_cookie("token_panier")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token_panier"));
        } else {
            $GLOBALS["quant"] = 0;
        }
    }

    public function index()
    {

        $data["controller"]= "import";
        return view('page_accueil/import.php', $data);
    }

    public function upload() {       
 
        $data["controller"] = "import";
        $csv = $this->request->getFile('file');
        $filepath = WRITEPATH . 'uploads/' . $csv->store();
        $data = ['uploaded_fileinfo' => new File($filepath)];
        $this->importCSV($filepath);
        return view('page_accueil/import.php', $data);
    }

    public function importCSV($filepath) {
        $data["controller"]= "import";
        $row = 0;
        $fichier = fopen($filepath, "r");
        $size = fstat($fichier)["size"];

        while (($dataCSV = fgetcsv($fichier, $size, ';')) !== FALSE) {
            $num = count($dataCSV);
            for ($c=0; $c < $num; $c++) {
                $retour[$row][$c] = $dataCSV[$c];
            }
            $row++;
        }
        fclose($fichier);
        $new_table = array();
        for ($i=0; $i < count($retour); $i++) { 
            //on itère sur chaque ligne
            if (count($retour[0]) == count($retour[$i]))
            {
                for ($j=0; $j < count($retour[0]); $j++) {
                    $new_table[$i][$retour[0][$j]] = $retour[$i][$j];
                }
            }
        }
        $result = array_slice($new_table,1);
        $importModel = model("\App\Models\ImportCSV");
        
        
        $importModel->CSVimport($result);
        delete_files(WRITEPATH.'uploads/', true);
        return view('page_accueil/import.php', $data);
    }
}