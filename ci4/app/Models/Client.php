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

    private function getClientByCredentials($comptes, $motDePasse) : \App\Entities\Client | null
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

    public function getClientByPseudo($pseudo, $motDePasse) : \App\Entities\Client | null
    {
        
        $comptes = $this->where('identifiant',$pseudo);
        
        return $this->getClientByCredentials($comptes, $motDePasse);
    }

    public function getClientByEmail($email, $motDePasse) : \App\Entities\Client | null
    {
        
        $comptes = $this->where('email',$email);
        
        return $this->getClientByCredentials($comptes, $motDePasse);
    }

    public function doesPseudoExists($pseudo) : bool
    {
        return !empty($this->where('identifiant',$pseudo)->findAll());
    }

    public function doesEmailExists($email) : bool
    {
        return !empty($this->where('email',$email)->findAll());
    }

    public function getClientById($id)
    {
        return $this->find($id);
    }

    public function saveClient(\App\Entities\Client $client)
    {
        $this->save($client);
    }

    /*
    Pas besoin de ces méthodes, voir mes remarques dans espaces client.
    //Principalement utilisées dans le controlleur EspaceClient.php 
    public function getClientPseudoById($id)
    {
        return $this->find($id)->getPseudo();
    }
    public function getClientPrenomById($id)
    {
        return $this->find($id)->getFirstName();
    }
    public function getClientNomById($id)
    {
        return $this->find($id)->getSurname();
    }
    public function getClientMailbyId($id)
    {
        return $this->find($id)->getMail();
    }

    public function saveClient($id)
    {
        $this->save($this->find($id)->getEntite());
    }

    public function setClientPseudoById($id, $nouveauPseudo)
    {
        $this->find($id)->setPseudo($nouveauPseudo);
    }
    public function setClientPrenomById($id, $nouveauPrenom)
    {
        $this->find($id)->setPrenom($nouveauPrenom);
    }
    public function setClientNomById($id, $nouveauNom)
    {
        $this->find($id)->setNom($nouveauNom);
    }
    public function setClientMailById($id, $nouveauMail)
    {
        $this->find($id)->setMail($nouveauMail);
    }
    */
}