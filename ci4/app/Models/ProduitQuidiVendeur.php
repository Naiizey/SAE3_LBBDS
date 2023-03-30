<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;
use \App\Models\ProduitPanierModel;
use CodeIgniter\Model;
use Exception;

class ProduitPanierCompteModel extends ProduitPanierModel
{
    protected $table      = 'sae3.produit_panier_vendeur';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id','id_prod','quantite','num_vendeur'];


    protected function getIdUser() : string{
        return (string)"num_vendeur";
    }

    protected function getColonneProduitIdUser(){
        return (string)'numVnd';
    }
}