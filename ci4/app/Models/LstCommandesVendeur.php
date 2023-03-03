<?php

namespace App\Models;

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

    
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_arriv','ht','ttc','etat'];


    

}