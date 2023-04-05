<?php namespace App\Controllers\Admin;


use App\Controllers\BaseQuidi;
use App\Entities\Vendeur;

class Quidi extends BaseQuidi
{


    public function __construct()
    {
        parent::__construct();
        $this->context="admin";
        $this->session=null;
        $this->model=model("\App\Models\ProduitQuidiAdmin");
        $this->modelJson=model("\App\Models\ProduitQuidiAdminJson");
    }

    private function trouverVendeurParQuidi($quidis){
        $vendeurModel = model("\App\Models\Vendeur");
        $vendeursInclus=array_map(fn($prod) => $prod->numVnd,$quidis);
        return $vendeurModel->getVendeurByIds(array_unique($vendeursInclus));
    }

    protected function trouverVendeur_sEtSetQuidi($quidi){
        $vendeurs=$this->trouverVendeurParQuidi($quidi);
        foreach($vendeurs as $vendeur){
            $vendeur->setArticles(array_filter($quidi,fn($prod) => $prod->numVnd==$vendeur->numero));
        }
        return $vendeurs;
    }







}