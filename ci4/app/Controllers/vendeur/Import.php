<?php namespace App\Controllers\vendeur;

use Exception;
use App\Controllers\BaseController;
use CodeIgniter\Files\File;

class Import extends BaseController
{
    private $feedback;
    protected $helpers = ['form', 'filesystem'];

    public function index($estVendeur=false)
    {
        $data["estVendeur"] = $estVendeur;
        $data["controller"]= "import";
        return view('vendeur/import.php', $data);
    }

    public function upload() {
        if (session()->has("just_importe") && session()->get("just_importe")) {
            $this->feedback=service("feedback");
            session()->set("just_importe", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Catalogue importé");
        }
        $data["controller"] = "import";
        $csv = $this->request->getFile('file');
        $filepath = WRITEPATH . 'uploads/' . $csv->store();
        $data = ['uploaded_fileinfo' => new File($filepath)];
        $this->importCSV($filepath);
        return view('vendeur/import.php', $data);
    }

    public function importCSV($filepath) {
        $data["controller"]= "import";
        $row = 0;
        $fichier = fopen($filepath, "r");
        $size = fstat($fichier)["size"];

        while (($dataCSV = fgetcsv($fichier, $size, ';')) !== false) {
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
        
        try{
        $importModel->CSVimport($result);

        }catch(\ErrorException $e){
            $errorDetail=$e->getMessage();
            if(str_contains($errorDetail,"constraint"))
            {
                $foundError="";
                $errorDetail=explode("\n",$errorDetail);
                foreach ($errorDetail as $detail){
                    if(str_contains($detail,"DETAIL:") && str_contains($detail,"already exists")){
                        $foundError=$detail;
                        break;
                    }
                    
                }
                if(!empty($foundError)){
                    throw new Exception($detail,404);
                }else{
                    throw new Exception("Erreur insertions: inconnue",500);
                }
            }
            else{
                throw $e;
            }
            
            
        }finally{
            delete_files(WRITEPATH.'uploads/', true);
        }
        session()->set("just_importe", true);
        return view('vendeur/import.php', $data);
    }

    /**
        * cette fonction prend les entêtes de la table produit et les retourne au format json /!\ Non finit !!!
        * @param none
        * @return json
     */
    public function getentetes()
    {
        $importModel = model("\App\Models\ImportCSV");
        $entetes = $importModel->getentete();
        header("Content-Type: application/json");
        echo json_encode($entetes);
        exit();
    }
}