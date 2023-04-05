<?php namespace App\Controllers\Vendeur;


use App\Controllers\BaseQuidi;


class Quidi extends BaseQuidi
{


    public function __construct()
    {
        parent::__construct();
        $this->context="vendeur";
        $this->session=session()->get("numeroVendeur");
        $this->model=model("\App\Models\ProduitQuidiVendeur");
        $this->modelJson=model("\App\Models\ProduitQuidiVendeurJson");
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

    protected function trouverVendeur_sEtSetQuidi($quidi){
        $vendeurModel = model("\App\Models\Vendeur");
        $vendeur=$vendeurModel->getVendeurById($this->session);
        $vendeur->serArticles=$quidi;
        return array($vendeur);
    }






}