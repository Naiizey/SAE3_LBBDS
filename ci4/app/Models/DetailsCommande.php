<?php

namespace App\Models;

use \App\Entities\CommandeCli as CommandeCli;
use CodeIgniter\Model;
use Exception;

class DetailsCommande extends Model
{
    protected $table      = 'sae3.commande_list_produits_client';

    protected $useAutoIncrement = false;

    protected $returnType     = CommandeCli::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_commande', 'id_prod','intitule_prod', 'lien_image_prod', 'description_prod','num_compte','date_commande','date_arriv','prix_ttc','prix_ht','qte','etat'];

    public function getArticles($num_commande) : array
    {
        return $this->where('num_commande',$num_commande)->findAll();
    }
}