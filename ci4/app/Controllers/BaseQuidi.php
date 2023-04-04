<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Cookie\Cookie;
use Config\Services;
use App\Controllers\BaseController;
use Exception;

class BaseQuidi extends BaseController
{
    protected $feedback;
    protected $context;
    public function __construct()
    {
        helper('cookie');
        $this->feedback=service("feedback");
        if (session()->has("just_connectee") && session()->get("just_connectee")==true) {
            session()->set("just_connectee", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Vous êtes connecté !");
        }
    }
    public function index()
    {
        return view("quidi.php");
    }




    /**
     * @method getProduitPanierVendeur
     * Récupére tout les produits du panier:
     *  -Vérification pour le feedback
     *  -Vérification et application des choix sur l'alerte fusion
     *  -Récupération contenu du panier
     *  Si panier rempli:
     *         -Récupération code réduction
     *
     * @return void
     */
    public function getProduitPanierVendeur()
    {
        $data['context']=$this->context;
        $data['model'] = model("\App\Models\ProduitCatalogue");
        $data['cardProduit'] = service("cardProduit");
        
        if(session()->has("just_vide") && session()->get("just_vide") == true) {
            $this->feedback=service("feedback");
            session()->set("just_vide", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Quidi vidé");
        }
      

        $data["controller"] = "Quidi";
        $issues = [];
        $retours = [];

        //Récupération des produits du panier

        if($this->context=="admin")
        {
            $modelProduitPanier = model("\App\Models\ProduitQuidiAdmin");
            $data['produits'] = $modelProduitPanier->getQuidi(null);
        }
        else if(session()->has("numeroVendeur") && $this->context=="vendeur")
        {
            $modelProduitPanier = model("\App\Models\ProduitQuidiVendeur");
            $data['produits'] = $modelProduitPanier->getQuidi(session()->get("numeroVendeur"));
        }
        else
        {
            $data['produits'] = array();
        }


        $data["erreurs"] = $issues;
        $data['retours'] = $retours;

        return view('quidi.php', $data);
    }

    public function viderQuidi() {
        if($this->context="admin")
        {
               
                $quidiModel = model("\App\Models\ProduitQuidiAdmin");
                $quidiModel->viderQuidi(null);
                
        }
        else if(session()->has("numeroVendeur") && $this->context="vendeur")
        {
            $quidiModel = model("\App\Models\ProduitQuidiVendeur");
            $quidiModel->viderQuidi(session()->get("numeroVendeur"));
        }
        else throw new \Exception("Le quidi n'existe pas !");
        
        
        session()->set("just_vide", true);
        return redirect()->to($this->context."/quidi")->withCookies();;
    }

    public function ajouterQuidi($idProd=null) {
        
        $data["controller"] = "Quidi";
        
        if(!is_null($idProd))
        {
            if($this->context="admin")
            {
               
                $quidiModel = model("\App\Models\ProduitQuidiAdmin");
                $quidiModel->ajouterProduit($idProd,null,true); 
                
            }
            else if(session()->has("numeroVendeur") && $this->context="vendeur")
            {
                      
                $quidiModel = model("\App\Models\ProduitQuidiVendeur");
                $quidiModel->ajouterProduit($idProd,session()->get("numeroVendeur"),true);
            }
        }
        
        
        if(isset($this->request)){
            session()->set("just_ajoute", true);
            return redirect()->to(session()->get("_ci_previous_url"));
        }
      
        return "tout va bien";
        
    
    }

    public function supprimerProduitQuidi($idProd = null){
        if(!is_null($idProd))
        {
            if($this->context="admin")
            {
               
                $quidiModel = model("\App\Models\ProduitQuidiAdmin");
                $quidiModel->deleteFromQuidi($idProd,null); 
                
            }
            else if(session()->has("numeroVendeur") && $this->context="vendeur")
            {
                $quidiModel = model("\App\Models\ProduitQuidiVendeur");
                $quidiModel->deleteFromQuidi($idProd,session()->get("numeroVendeur"));
            }
            else throw new \Exception("Le quidi n'existe pas !");
        }
        if(isset($this->request)){
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