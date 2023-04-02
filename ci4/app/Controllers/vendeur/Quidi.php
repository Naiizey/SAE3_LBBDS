<?php namespace App\Controllers\Vendeur;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Cookie\Cookie;
use Config\Services;
use App\Controllers\BaseController;
use Exception;

class Quidi extends BaseController
{
    private $feedback;

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
        return view('vendeur/quidi');
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
        $data['model'] = model("\App\Models\ProduitCatalogue");
        $data['cardProduit'] = service("cardProduit");
        
        if(session()->has("just_vide") && session()->get("just_vide") == true) {
            $this->feedback=service("feedback");
            session()->set("just_vide", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Quidi vidé");
        }
        $get=$this->request->getGet();

        $data["controller"] = "Quidi";
        $issues = [];
        $retours = [];

        //Récupération des produits du panier
        if(session()->has("numeroVendeur"))
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

        return view('vendeur/quidi.php', $data);
    }

    public function viderQuidi() {
        if(session()->has("numeroVendeur"))
        {
            $quidiModel = model("\App\Models\ProduitQuidiVendeur");
            $quidiModel->viderQuidi(session()->get("numeroVendeur"));
        }
        else throw new \Exception("Le quidi n'existe pas !");
        
        
        session()->set("just_vide", true);
        return redirect()->to("vendeur/quidi")->withCookies();;
    }

    public function ajouterQuidi($idProd=null) {
        $data["controller"] = "Quidi";
        
        if(!is_null($idProd))
        {
        
            if(session()->has("numeroVendeur"))
            {
                            
                $quidiModel = model("\App\Models\ProduitQuidiVendeur");
                $quidiModel->ajouterProduit($idProd,session()->get("numeroVendeur"),true);
            }
        }

        if(isset($this->request)){
            session()->set("just_ajoute", true);
            return redirect()->to(session()->get("_ci_previous_url"));
        }
       
        
    
    }

    public function supprimerProduitQuidi($idProd = null){
        if(!is_null($idProd))
        {
            if(session()->has("numeroVendeur"))
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
}