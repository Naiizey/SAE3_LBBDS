<?php

namespace App\Controllers\vendeur;

use Exception;
use App\Controllers\BaseController;
use App\Controllers\client\Produits as ClientProduits;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\throwException;

/**
 * @method getAllProduitSelonPage($page=null,$filters=null)
 */

class Produits extends ClientProduits {

    public function __construct()
    {
        $this->model= model("\App\Models\ProduitCatalogueVendeur")->where("num_compte =", session()->get("numeroVendeur"));

    }
   
}   