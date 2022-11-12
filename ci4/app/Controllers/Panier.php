<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use Exception;

class Panier extends BaseController
{
    public function index()
    {
        return view('panier/index.php');
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

    public function getProduitPanierClient($context = null)
    {
        $data['controller']= "panier";
        if($context == 400)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        else{
            $data['produits'] = model("\App\Models\ProduitPanierCompteModel")->getPanier(session()->get("numero"));

        }
        
    
        
        return view('page_accueil/panier.php', $data);
    }

    public function viderPanier() {
   
        if(session()->has("numero"))
        {
            $panierModel = model("\App\Models\ProduitPanierCompteModel");
            $panierModel->viderPanier(session()->get("numero"));
        }
        else if(cookies()->has("token_panier"))
        {
            //TODO: vider en tant qu'internautes
        }
        else throw new \Exception("Le panier n'existe pas !");
        
        
        
        return redirect()->to("panier");
    }

    /*
    public function ajouterPanier() {
        $data['controller'] = "panier";
        $session = session();
        $panier = $session->get('panier');
        $idProduit = $this->request->getPost('idProduit');
        $quantite = $this->request->getPost('quantite');
        if($panier == null) {
            $panier = array();
        }
        if(array_key_exists($idProduit, $panier)) {
            $panier[$idProduit] += $quantite;
        } else {
            $panier[$idProduit] = $quantite;
        }
        $session->set('panier', $panier);
        $panierModel = model("\App\Models\ProduitPanierModel");
        $panierModel->ajouterProduitPanier($idProduit, $quantite);
        return view('page_accueil/panier.php', $data);
    }
    */

    public function ajouterPanier($idProd=null,$quantite=null) {
        $data['controller'] = "panier";
        
       if(!is_null($idProd) && !is_null($quantite))
       {
            if(session()->has("numero"))
            {
                            
                $panierModel = model("\App\Models\ProduitPanierCompteModel");
                $panierModel->ajouterProduit($idProd,$quantite,session()->get("numero"),$quantite,true);
            }
            else if(cookies()->has("token_panier"))
            {
                //TODO: vider en tant qu'internautes
            }
            else 
            {
                //TODO: création du panier
                //temporaire:
                throw new \Exception("Non implémenté");
            }

            
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
            else if(cookies()->has("token_panier"))
            {
                //TODO: vider en tant qu'internautes
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

        if(!isset($this->request)) return $result;

        else if($this->request->getMethod()==="put")
        {
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode($code)->setJSON($result);
        }
        
        else if(isset($this->request) && $this->request->getMethod()==="get")
        {
            return redirect()->to(session()->get("_ci_previous_url"));
        }
        
      
      
  
    }

    public function sendCors($idProd = null, $newQuantite = null){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
  
    }
}