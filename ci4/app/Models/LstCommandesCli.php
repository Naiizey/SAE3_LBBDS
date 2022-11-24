<?php

namespace App\Models;

use \App\Entities\CommandeCli as CommandeCli;
use CodeIgniter\Model;
use Exception;

class LstCommandesCli extends Model
{
    protected $table      = 'sae3.commande_list_client';
    protected $primaryKey = 'num_panier';

    protected $useAutoIncrement = false;

    protected $returnType     = CommandeCli::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_arriv','prix_ht','prix_ttc','etat'];

    public function getCompteCommandes(){
        return $this->where('num_compte',session()->get("numero"))->findAll();
    }

}