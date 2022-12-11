<?php

namespace App\Controllers;

use Exception;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\throwException;

/**
 * @method getAllProduitSelonPage($page=null,$filters=null)
 * 
 */

class Produits extends BaseController 
{

    private const NBPRODSPAGEDEFAULT = 20;
    
    /**
     * @method getAllProduitSelonPage
     * Permet de récupérer un intervalle de produit selon des filtres la méthode peut être appelé via une autre méthode php ou via XML.
     * 
     * @param $page=1  
     * @param $nombreProd=self::NBPRODSPAGEDEFAULT 
     * @param $filters=null 
     *
     * Pour return:
     * @see giveResult();
     */
    public function getAllProduitSelonPage($page=1,$nombreProd=self::NBPRODSPAGEDEFAULT,$filters=null){
       

        if($filters==null && isset($this->request) && !empty($this->request->getVar())){
            $filters=$this->request->getVar();
        }

        $data=array();

        try{
            if(is_null($filters) || empty($filters))
            {
                
                $result= model("\App\Models\ProduitCatalogue")->findAll(
                    ($nombreProd*$page)+1,
                    $nombreProd*($page-1)
                    
                    
                       
                );
                
         
            }
            else
            {
                
                $result=$this->casFilter($filters,$data)->findAll(
                    ($nombreProd*$page)+1,
                    $nombreProd*($page-1)
                       
                );
                //dd("dz");
                //$nbResults=sizeof($this->casFilter($filters,$data)->findAll());
             
                if(empty($result)){
                    return $this->throwError(new Exception("Aucun produit disponible avec les critères sélectionnés",404));
                }
            }
            if(sizeof($result)<$nombreProd+1){
                $dernier=true;
            }else{
                $dernier=false;
                unset($result[$nombreProd]);
            }

        
        }catch(\CodeIgniter\Database\Exceptions\DataException $e){
            $this->throwError($e);
        }
       
           
        
        //dd($result,$dernier,($nombreProd*$page)+1,
        //  $nombreProd*($page-1));
        return $this->giveResult($result,$dernier);

    }

    public function sendCors(){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','GET, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
  
    }

       
    /**
     * @method casFilter
     * Construit une requête sql qui filtre les produits en fonction des recherches et des filtres
     *
     * @param $filters array 
     * @param $data $data 
     *
     * @return \App\Models\ProduitCatalogue
     */
    private function casFilter($filters,$data) : object{
        $result = array();
        
        if (isset($filters["search"])) {
            $search = $filters["search"];
            unset($filters["search"]);
        }
        
       
        $query = model("\App\Models\ProduitCatalogue",false);

        


        if (isset($filters["prix_min"]) && isset($filters["prix_max"])) {
            
            $query->where('prixttc >=', $filters["prix_min"])->where('prixttc <=', $filters["prix_max"]);
            unset($filters["prix_min"]);
            unset($filters["prix_max"]);
            
        }


        if(!empty($filters)){
            $subQuery = db_connect()->table($query->table)->select('id');
            foreach (array_keys($filters) as $key) {
                $subQuery->orWhere('categorie', $key);
                //d($key);
            }
            $query->whereIn('id',$subQuery);
            
        }
        

        if(isset($search) && $search!==""){
            $subQuery = db_connect()->table($query->table)->select('id');
            $subQuery->like('LOWER(intitule)', strToLower($search))->orLike('LOWER(description_prod)', strToLower($search))/*->orderby('intitule, description_prod', 'ASC')*/;
            $query->whereIn('id',$subQuery);    
            
        }
        
        
        
        
        
        
        
     
        return $query;
        
    }

        
    /**
     * @method throwError
     * Throw l'erreur en fonction de si on la fonction a été appelé apr une autre fonction ou si elle a été appelle par une requête
     *
     * @param Exception $e 
     *
     * 
     */
    private function throwError(Exception $e){
        if(isset($this->request)){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode($e->getCode())->setJSON(array("message"=>$e->getMessage()));
        }
        else{
            return array("resultat"=>[],"estDernier"=>true,"message"=>$e->getMessage());
        }
    }

        
    /**
     * Method giveResult
     *
     * @param $result 
     * @param $dernier 
     *
     * Return en fonction de si la fonction est appelé par une autre fonction array et retourne un JSON si appelé par une requête
     * 
     * 
     */
    private function giveResult($result,$dernier){
    
        
        
        if(isset($this->request)){
            $retour=[];
            foreach($result as $prod){
                $retour[]=service("cardProduit")->display($prod);
            }
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200)->setJSON(array("resultat"=>$retour,"estDernier"=>$dernier));
        }
        else{
            return array("resultat"=>$result,"estDernier"=>$dernier);
        }
    }

    

    

    
}