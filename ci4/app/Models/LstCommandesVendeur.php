<?php

namespace App\Models;

use App\Entities\CommandeCli;
use \App\Entities\CommandeVend as CommandeVend;
use CodeIgniter\Model;
use Exception;

/**
 * Accès aux commandes réliès à leurs vendeurs
 * 
 *  Données:
 *      * vendeur: -**R**-- 
 *      * commentaire: -**R**-- 
 */
 
class LstCommandesVendeur extends Model
{
    protected $table      = 'sae3.commande_list_vendeur';
    protected $primaryKey = 'num_panier';

    protected $useAutoIncrement = false;

    protected $returnType     = CommandeCli::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_arriv','prix_ht','prix_ttc','etat', 'montant_reduction', 'pourcentage_reduction','num_vendeur'];

    public function getCompteCommandes() : array
    { 
        return $this->where('num_vendeur',session()->get("numeroVendeur"))->findAll();
    }

    public function getCommandeByIdAndVendeur($num_commande,$num_vendeur){
        return $this->where('num_commande',$num_commande)->where('num_vendeur',$num_vendeur)->findAll();
    }
}