<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Cookie\Cookie;
use Config\Services;
use Exception;

class Panier extends BaseController
{

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
        return view('panier/index.php',);
    }

    public function test()
    {
        echo "Hello World";
    }

    public function verification(){
        $auth = service('authentification');
        $verif=$auth->connexion($this->request->getPost()); 
        if($verif){
            return redirect()->to("/");
        }
        else{
            return redirect()->to("/connexion/400");
        }
        
    }
    /*
    // fonction qui permet de récupérer les produits du panier
    public function getProduitsPanier(){
        $session = session();
        $panier = $session->get('panier');
        $produits = array();
        $produitModel = model("\App\Models\Produit");
        foreach($panier as $idProduit => $quantite){
            $produit = $produitModel->find($idProduit);
            $produit->quantite = $quantite;
            $produits[] = $produit;
        }
        return $produits;
    }
    */

    #TODO: valeur pas update au début.  
    public function getProduitPanierClient($context = null, $data = null)
    {
        $data['controller'] = "panier";
        $data['erreurs'] = [];
        if($context == 400) 
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        else if(session()->has("numero")) {
            $data['produits'] = model("\App\Models\ProduitPanierCompteModel")->getPanier(session()->get("numero"));

        }
        else if(has_cookie("token_panier")) {
            $data['produits'] = model("\App\Models\ProduitPanierVisiteurModel")->getPanier(get_cookie("token_panier"));
        
        }
        else {
            $data['produits']=array();
        }
        return view('page_accueil/panier.php', $data);
    }

    public function viderPanier() {
        if(session()->has("numero"))
        {
            $panierModel = model("\App\Models\ProduitPanierCompteModel");
            $panierModel->viderPanier(session()->get("numero"));
        }
        else if(has_cookie("token_panier"))
        {
            $panierModel = model("\App\Models\ProduitPanierVisiteurModel");
            $panierModel->viderPanier(get_cookie("token_panier"));
            $this->updatePanier(get_cookie("token_panier"));
        }
        else throw new \Exception("Le panier n'existe pas !");
        
        
        
        return redirect()->to("panier");
    }

    public function ajouterPanier($idProd=null,$quantite=null) {
        $data['controller'] = "panier";
        
        if($quantite==null && isset($this->request)){
            if($this->request->getPost("quantie")==="10+")
            {
                $quantite=$this->request->getPost("quantite");
            }
            else 
            {
                $quantite=$this->request->getPost("quantitePlus");
            }
           
        }
        
        if(!is_null($idProd) && !is_null($quantite))
        {
        
            if(session()->has("numero"))
            {
                            
                $panierModel = model("\App\Models\ProduitPanierCompteModel");
                $panierModel->ajouterProduit($idProd,$quantite,session()->get("numero"),$quantite,true);
            }
            else if(has_cookie("token_panier") && model("\App\Models\ProduitPanierVisiteurModel")->estConsigne(get_cookie("token_panier")))
            {
                $panierModel = model("\App\Models\ProduitPanierVisiteurModel");
                
                $panierModel->ajouterProduit($idProd,$quantite,get_cookie("token_panier"),$quantite,true);

                $this->updatePanier(get_cookie("token_panier"));
                
                
            }
            else 
            {
                
                $token=$this->creerPanier();
                $panierModel = model("\App\Models\ProduitPanierVisiteurModel");
                $panierModel->ajouterProduit($idProd,$quantite,$token,$quantite,true);
                //return $token;
                
              
            }
            
                
            
        }

        if(isset($this->request)){
            return redirect()->to(session()->get("_ci_previous_url"));
        }
       
        
    
    }

    public function supprimerProduitPanier($idProd = null){
        if(!is_null($idProd))
        {
            if(session()->has("numero"))
            {
                $panierModel = model("\App\Models\ProduitPanierCompteModel");
                $panierModel->deleteFromPanier($idProd,session()->get("numero"));
            }
            else if(has_cookie("token_panier"))
            {
                $panierModel = model("\App\Models\ProduitPanierVisiteurModel");
                $panierModel->deleteFromPanier($idProd,get_cookie("token_panier"));
                $this->updatePanier(get_cookie("token_panier"));
            }
            else throw new \Exception("Le panier n'existe pas !");
        }
        if(isset($this->request)){
            return redirect()->to(session()->get("_ci_previous_url"));
        }
    }

    public function modifierProduitPanier($id = null, $newQuantite = null){

        
            if (session()->has('numero'))
            {
            try{
                model("\App\Models\ProduitPanierCompteModel")->changerQuantite($id,session()->get('numero'),$newQuantite);
                $result = array("prodChanged" => $id,"forClientId" => session()->get('numero'));
                $code=200;
            }catch(\Exception $e){
                $result = array("error" => $e);
                $code=500;
            }
            } 
            else if(has_cookie("token_panier"))
            {   
                try{
                    model("\App\Models\ProduitPanierVisiteurModel")->changerQuantite($id, get_cookie("token_panier"),$newQuantite);
                    $result = array("prodChanged" => $id,"forClientId" =>  get_cookie("token_panier"));
                    $code=200;
                    $this->updatePanier(get_cookie("token_panier"));
                
                }catch(\ErrorException $e){
                    //echo $e;
                    $result = array("error" => $e->getMessage());
                    $code=500;
                }
                
               
            }
            else throw new \Exception("Le panier n'existe pas !");

        
            
            if(!isset($this->request)) return $result;

            else if($this->request->getMethod()==="put")
            {
                return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
                ->setStatusCode($code)->setJSON($result);
            }
            /*
            else if(isset($this->request) && $this->request->getMethod()==="get")
            {
                return redirect()->to(session()->get("_ci_previous_url"));
            }
            */
    }

    public function sendCors($idProd = null, $newQuantite = null){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
    }

    public function creerPanier(){
        $token = bin2hex(\openssl_random_pseudo_bytes(16));
        $expiration=strtotime('+24 hours');
        $model=model("\App\Models\ProduitPanierVisiteurModel");
        $token=$model->createPanierVisiteur($token,$expiration);


        setcookie('token_panier',$token,array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
        return $token;
    }

    public function updatePanier($token){
        
        $expiration=strtotime('+24 hours');
        $model=model("\App\Models\ProduitPanierVisiteurModel");
        $token=$model->updatePanierVisiteur($token,$expiration);


        setcookie('token_panier',$token,array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
        return $token;
    }

    public function validerCode()
    {
        $post=$this->request->getPost();
        $modelCodeReduc = model("\App\Models\CodeReduction");
        
        if (!empty($post))
        {
            $codeReduc = $modelCodeReduc->getByCode($post['code']);

            if (empty($codeReduc))
            {
                $issues[1] = "Ce code n'existe pas";
            }
            else
            {
                //if ($codeReduc->)
            }
        }
        else
        {
            $issues[0] = "Pas d'entrée";
        }

        $data["erreurs"] = $issues;
        $data["controller"] = "panier";

        return redirect()->to("/panier");
    }
}