<?php

namespace App\Controllers;

use Exception;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\throwException;

/**
 * @method getAllProduitSelonPage($page=null,$filters=null) permet de récupérer un intervalle de produit selon des filtres 
 * la méthode peut être appelé via une autre méthode php ou via XML.
 * 
 */

class Produits extends BaseController 
{

    private const NBPRODSPAGECATALOGUE = 18;

    public function getAllProduitSelonPage($page=null,$filters=null){

        if($filters==null && isset($this->request) && !empty($this->request->getVar())){
            $filters=$this->request->getVar();
        }

        $data=array();

        try{
            if(is_null($filters) || empty($filters))
            {
                
                $result=model("\App\Models\ProduitCatalogue")->findAll();
            }
            else
            {
                $result=$this->casFilter($filters,$data);
                if(empty($result)){
                    return $this->throwError(new Exception("Aucun produit disponible avec les critères sélectionnés",404));
                }
            }

        
        }catch(\CodeIgniter\Database\Exceptions\DataException $e){
            $this->throwError($e);
        }
       
           
        
        

        return $this->giveResult($result);

    }

    public function sendCors(){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
  
    }

    private function casFilter($filters,$data){
        $result = array();
        $modelProduitCatalogue=model("\App\Models\ProduitCatalogue");
        if (isset($filters["search"])) {
            $search = $filters["search"];
            unset($filters["search"]);
        }
     
       
        $priceQuery = model("\App\Models\ProduitCatalogue",false);
        if (isset($filters["prix_min"]) && isset($filters["prix_max"])) {
            
            $priceQuery = $priceQuery->where('prixttc >=', $filters["prix_min"])->where('prixttc <=', $filters["prix_max"]);
            unset($filters["prix_min"]);
            unset($filters["prix_max"]);
            
        }
        
        
        if(!empty($filters)){
            foreach (array_keys($filters) as $key) {
                $priceQuery=$priceQuery->where('categorie', $key);
            }
        }

        if(isset($search)){
            $priceQuery=$priceQuery->like('intitule', strToLower($search))->orLike('description_prod', strToLower($search))->orderby('intitule, description_prod', 'ASC');

        }
        $result=$priceQuery->findAll();

        return $result;
        
    }


    private function throwError(Exception $e){
        if(isset($this->request)){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode($e->getCode())->setJSON(array("message"=>$e->getMessage()));
        }
        else{
            throw $e;
        }
    }

    private function giveResult($result){
        if(isset($this->request)){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200)->setJSON($result);
        }
        else{
            return $result;
        }
    }

    

    
}