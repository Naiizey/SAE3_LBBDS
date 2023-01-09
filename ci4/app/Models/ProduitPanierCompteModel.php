<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;
use \App\Models\ProduitPanierModel;
use CodeIgniter\Model;
use Exception;

class ProduitPanierCompteModel extends ProduitPanierModel
{
    protected $table      = 'sae3.produit_panier_compte';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id','id_prod','quantite','num_client'];


    protected function getIdUser() : string{
        return (string)"num_client";
    }

    protected function getColonneProduitIdUser(){
        return (string)'numCli';
    }

    public function fusionPanier($numPanier,$token){
        $this->db->query("SELECT * FROM sae3.transvasagePanier('$token' ,$numPanier)");
    }
}