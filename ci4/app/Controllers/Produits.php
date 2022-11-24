<?php

namespace App\Controllers;

use Exception;

use function PHPUnit\Framework\isNull;

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

        try{
            if(is_null($filters) || empty($filters))
            {
                
                $result=model("\App\Models\ProduitCatalogue")->findAll();
            }
            else
            {
                dd($filters);
                throw new Exception("Error 501: Pas implémenté");
            }

            $code=200;
        }catch(\CodeIgniter\Database\Exceptions\DataException $e){
            $result = array("error" => $e);
            $code=500;
        }
        if($code=200)
        {
            $data['nombreMaxPages']=intdiv(sizeof($result),self::NBPRODSPAGECATALOGUE)
                + ((sizeof($result) % self::NBPRODSPAGECATALOGUE==0)?0:1) ;
            if(is_null($page) || $page==0)
            {
                $data['minProd']=0;
                $data['maxProd']=self::NBPRODSPAGECATALOGUE;
                $data['page']=1;
            }
            else
            {
                if($data['nombreMaxPages']>=$page)
                {
                    

                    $data['minProd']=self::NBPRODSPAGECATALOGUE*($page-1);
                    $data['maxProd']=self::NBPRODSPAGECATALOGUE*$page;
                    $data['page']=$page;
                    
                }
                else return view('errors/html/error_404.php', array('message' => "Page trop haute: pas assez de produit"));
            }
        }
        

        if(isset($this->request))
        {
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
                ->setStatusCode($code)->setJSON($result);
            
        }
        else if($code==200)
        {
            $data['prods']=$result;
            return $data;
        }
        else return $result;

    }

    public function sendCors(){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
  
    }

    
}