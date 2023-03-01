<?php

namespace App\Models;

use CodeIgniter\Model;


/** 
 * Model de classe client qui permet de récuperer un client, ainsi qu'insérer et mettre à jour.
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Client
 */
class Client extends Compte
{
    protected $table      = 'sae3.client';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Client::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['numero','nom','prenom','email','identifiant','motdepasse'];

    public function getClientByPseudo($pseudo, $motDePasse) : \App\Entities\Client | null
    {
        $comptes = $this->where('identifiant',$pseudo);

        return parent::getCompteByCredentials($comptes, $motDePasse);
    }

    public function getClientByEmail($email, $motDePasse) : \App\Entities\Client | null
    {
        $comptes = $this->where('email',$email);

        return parent::getCompteByEmail($email, $motDePasse);
    }

    public function getClientById($id)
    {
        return parent::getCompteById($id);
    }

    public function saveClient(\App\Entities\Client $client)
    {
        parent::saveCompte($client);
    }

    
}