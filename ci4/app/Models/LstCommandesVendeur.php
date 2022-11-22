<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;
use \App\Models\ProduitPanierModel;
use CodeIgniter\Model;
use Exception;

class LstCommandesVendeur extends Model
{
    protected $table      = 'sae3.commande_list_vendeur';
    protected $primaryKey = 'num_panier';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_arriv','ht','ttc','etat'];


    

}