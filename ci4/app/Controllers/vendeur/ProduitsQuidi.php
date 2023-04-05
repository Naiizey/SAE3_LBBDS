<?php

namespace App\Controllers\vendeur;

use Exception;
use App\Controllers\BaseController;
use App\Controllers\client\Produits as ClientProduits;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\throwException;

class ProduitsQuidi extends ClientProduits {

    public function __construct()
    {
        $this->model= model("\App\Models\ProduitQuidiVendeur")->where("num_vendeur =", session()->get("numeroVendeur"));
        $this->nom_intitule = "intitule_prod";
    }
}   