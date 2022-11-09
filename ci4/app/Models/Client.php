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
class Client extends Model
{
    protected $table      = 'sae3.client';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Client::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nom','prenom','email','identifiant','motdepasse'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    private function getClientByCredentials($comptes, $motDePasse, bool $esthashee) //: \App\Entities\Client | null
    {
        
        
        
            
        if(!$esthashee)
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
        else
        {
            $comptes=$comptes->where('motdepasse',$motDePasse)->findAll();
            return (sizeof($comptes)!=0) ? $comptes[0] : null;
        }
      
        
    }

    public function getClientByPseudo($identifiant, $motDePasse, bool $esthashee) //: \App\Entities\Client | null
    {
        
        $comptes = $this->where('identifiant',$identifiant);
        
        return $this->getClientByCredentials($comptes, $motDePasse, $esthashee);
      
        
    }

    public function getClientByEmail($identifiant, $motDePasse, bool $esthashee) //: \App\Entities\Client | null
    {
        
        $comptes = $this->where('email',$identifiant);
        
        return $this->getClientByCredentials($comptes, $motDePasse, $esthashee);
      
        
    }

}