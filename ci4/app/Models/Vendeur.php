<?php

namespace App\Models;

use CodeIgniter\Model;



/** 
 * Model de classe client qui permet de récuperer un client, ainsi qu'insérer et mettre à jour.
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Vendeur
 */
class Vendeur extends Compte
{
    protected $table      = 'sae3.vendeur';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Vendeur::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['identifiant','motdepasse','email'];


    public function getVendeurByCredentials($comptes, $motDePasse) : \App\Entities\Vendeur | null
    {
        return parent::getCompteByCredentials($comptes, $motDePasse);
    }

    public function getVendeurByPseudo($pseudo, $motDePasse) : \App\Entities\Vendeur | null
    {
        
        return parent::getCompteByPseudo($pseudo, $motDePasse);
    }

    public function getVendeurByEmail($email, $motDePasse) : \App\Entities\Vendeur | null
    {
        
        return parent::getCompteByEmail($email, $motDePasse);
    }


    public function getVendeurById($id)
    {
        return parent::getCompteById($id);
    }

    public function saveVendeur(\App\Entities\Vendeur $vendeur)
    {
        parent::saveCompte($vendeur);
    }

    
}