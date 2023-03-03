<?php namespace App\Models;

use CodeIgniter\Model;

class Commande extends Model
{
    protected $primaryKey = 'num_panier';

    protected $useAutoIncrement = false;

    protected $returnType     = Commande::class;
    protected $useSoftDeletes = false;   
    
    protected $table      = 'sae3.commande_list_client';
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_arriv','prix_ht','prix_ttc','etat', 'montant_reduction', 'pourcentage_reduction'];

    


}