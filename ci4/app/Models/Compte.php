<?php

namespace App\Models;

use CodeIgniter\Model;


/** 
 * Model de classe compte qui permet de récuperer un compte, ainsi qu'insérer et mettre à jour. 
 * @abstract App\Models\Client et de App\Models\Vendeur 
 * 
 */
abstract class Compte extends Model
{
    /*
    protected $table      = 'sae3.client';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Client::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nom','prenom','email','identifiant','motdepasse'];
    */
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected function getCompteByCredentials($comptes, $motDePasse)
    {
        $comptes=$comptes->findAll();
        if(sizeof($comptes) != 0)
        {
            $retour=null;
            foreach($comptes as $trouve){
            
                if($trouve->verifCrypt($motDePasse)){
                    $retour=$trouve;
                }
            }
            return $retour;
        }
        else return null;
    }

    public function doesPseudoExists($pseudo) : bool
    {
        return !empty($this->where('identifiant',$pseudo)->findAll());
    }

    public function doesEmailExists($email) : bool
    {
        return !empty($this->where('email',$email)->findAll());
    }

    protected function getCompteById($id)
    {
        return $this->find($id);
    }

    protected function saveCompte($client)
    {
        $this->save($client);
    }
}