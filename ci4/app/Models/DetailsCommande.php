<?php

namespace App\Models;

use \App\Entities\CommandeCli as CommandeCli;
use CodeIgniter\Model;
use Exception;

class DetailsCommande extends Model
{
    protected $table      = 'sae3.commande_list_produits_client';

    protected $useAutoIncrement = false;

    protected $returnType     = DetailsCommande::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_commande','intitule_prod','num_compte','date_commande','date_arriv','prix_ttc','prix_ht','qte','etat'];

    public function getArticles($num_commande){
        return $this->where('num_commande',$num_commande)->findAll();
    }
}