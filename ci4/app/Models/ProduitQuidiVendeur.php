<?php

namespace App\Models;

use \App\Entities\ProduitQuidi as Produit;
use \App\Models\ProduitQuidiModel;
use CodeIgniter\Model;
use Exception;


class ProduitQuidiVendeur extends ProduitQuidiModel
{
    protected $table      = 'sae3.produit_quidi_vendeur';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id','id_prod','num_vendeur'];


    protected function whereSiVendeur($idVendeur)
    {
        if(is_null($idVendeur))
            throw new Exception("Ne devrais pas avoir un id Vendeur null");
        return $this->where("num_vendeur",$idVendeur);
    }
}