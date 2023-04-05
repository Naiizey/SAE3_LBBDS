<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Cookie\Cookie;
use Config\Services;
use App\Controllers\BaseController;
use Exception;

abstract class BaseQuidi extends BaseController
{
    protected $feedback;
    protected $context;
    protected $session;
    protected $model;
    protected $modelJson;
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

        if(session()->has("numeroVendeur") || $this->context=="admin")
        {
            $modelProduitPanier = $this->model;
            $data['produits'] = $modelProduitPanier->getQuidi($this->session);
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
        
        if(session()->has("numeroVendeur") || $this->context="admin")
        {
            $quidiModel = $this->model;;
            $quidiModel->viderQuidi($this->session);
        }
        else throw new \Exception("Le quidi n'existe pas !");
        
        
        session()->set("just_vide", true);
        return redirect()->to($this->context."/quidi")->withCookies();;
    }

    public function ajouterQuidi($idProd=null) {
        
        $data["controller"] = "Quidi";
        
        if(!is_null($idProd))
        {
            if(session()->has("numeroVendeur") || $this->context="vendeur")
            {
                      
                $quidiModel = $this->model;;
                $quidiModel->ajouterProduit($idProd,$this->session,true);
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
           if(session()->has("numeroVendeur") || $this->context="vendeur")
            {
                $quidiModel = $this->model;
                $quidiModel->deleteFromQuidi($idProd,$this->session);
            }
            else throw new \Exception("Le quidi n'existe pas !");
        }
        if(isset($this->request)){
            return redirect()->to(session()->get("_ci_previous_url"));
        }
    }

   

    protected abstract function trouverVendeur_sEtSetQuidi($quidi);



    public function validationQuidi()
    {
        //on pick le numéro vendeur
        if(session()->has("numeroVendeur") || $this->context="admin")
        {
            $quidiModel = $this->modelJson;

            //On récupère le quidi
            $quidi = $quidiModel->getQuidi($this->session);

            //On récupère les vendeurs
            $vendeurs = $this->trouverVendeur_sEtSetQuidi($quidi);

            //On ajoute un champ à l'objet vendeur
            $catalogueur = array();
            $catalogueur["entreprises"] = $vendeurs;
            $catalogueur["articles"] = $quidi;

            // Convertir le tableau en JSON
            $json = json_encode($catalogueur);

            // Enregistrer le JSON dans un fichier en local
            try 
            {
                $file = fopen(dirname(__DIR__,3) . "/catalogueur/samples/mono.json", "w");
                fwrite($file, $json);
                fclose($file);

                //On éxécute le script shell qui va convertir le json en pdf
                $log = null;
                exec("cd " . dirname(__DIR__,3) . "/catalogueur/scripts && /bin/bash go", $log);
                //print_r($log);

                //On ouvre le pdf dans le navigateur
                $file = dirname(__DIR__,3) . "/catalogueur/catalogue.pdf";
                $this->response->setHeader("Content-type", "application/pdf");
                $this->response->setHeader("Content-Disposition", "inline; filename=catalogue.pdf");
                @readfile($file);
            } 
            catch (\Throwable $th) 
            {
                throw new \Exception("Erreur lors de la création du fichier");
            }
        }
        else throw new \Exception("Le quidi n'existe pas !");
    }


    public function sendCors($idProd = null, $newQuantite = null){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
    }


}