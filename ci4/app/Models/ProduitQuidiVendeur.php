<?php

namespace App\Models;

use \App\Entities\ProduitQuidi as Produit;
use \App\Models\ProduitQuidiModel;
use CodeIgniter\Model;
use Exception;

class ProduitQuidiVendeur extends ProduitQuidiModel
{
    protected $table      = 'sae3.produit_quidi';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id','id_prod','num_vendeur'];


    protected function getIdVendeur() : string{
        return (string)"num_vendeur";
    }

    protected function getColonneProduitIdVendeur(){
        return (string)'numVnd';
    }
}