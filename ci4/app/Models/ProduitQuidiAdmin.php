<?php

namespace App\Models;

use \App\Entities\ProduitQuidi as Produit;
use \App\Models\ProduitQuidiModel;
use CodeIgniter\Model;
use Exception;

class ProduitQuidiAdmin extends ProduitQuidiModel
{
    protected $table      = 'sae3.produit_quidi_admin';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id','id_prod'];

    protected function whereSiVendeur($idVendeur){
        if(!is_null($idVendeur))
            throw new Exception("Ne devrais pas être utilisé avec un id Vendeur");
          
        return $this;
    }



    
 
}