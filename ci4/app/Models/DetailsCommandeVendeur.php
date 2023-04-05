<?php

namespace App\Models;

use \App\Entities\Commande as Commande;
use CodeIgniter\Model;
use Exception;

/**
 * Permet d'accéder au détail d'une commande
 * 
 *  Données:
 *      * commande: -**R**-- 
 *     
 */
 
class DetailsCommandeVendeur extends Model
{
    protected $table      = 'sae3.commande_list_produits_vendeur';

    protected $useAutoIncrement = false;

    protected $returnType     = Commande::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_commande', 'id_prod','intitule_prod', 'lien_image_prod', 'description_prod','num_compte','date_commande','date_arriv','prix_ttc','prix_ht','qte','etat', 'montant_reduction', 'pourcentage_reduction', 'num_vendeur'];

    public function getArticles($num_commande,$num_vendeur) : array
    {
        return $this->where('num_commande',$num_commande)->where('num_vendeur',$num_vendeur)->findAll();
    }
}