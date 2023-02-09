<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Vendeur extends Entity
{
    private bool $isCrypted = false;



    public function verifCrypt(string $entree) : bool{
        if (password_verify($entree,$this->motDePasse))
        {
            $this->isCrypted=true;
            return true;
        }
        else return false;
    }

    
  

    public function __toString()
    {
        return "<p>$this->identifiant</p>Identifiant: $this->identifiant";
    }


    public function cryptMotDePasse(){
        $this->motDePasse=password_hash($this->motDePasse,PASSWORD_BCRYPT,array('cost' => 12));
        $isCrypted=true;
    }

    public function estCryptee() : bool{
        return $this->isCrypted;
    }


    public $datamap= [
        #numero
        'motDePasse' => 'motdepasse',
        'v_nom' => 'nom',
        'v_prenom' => 'prenom',
        'nom' => 'nom',
        'prenom' => 'prenom',
        #identifiant
        'identifiant' => 'identifiant',
        'pseudo' => 'identifiant'
    ];

    protected $attributes = [
        'nom' => null,
        'prenom' => null
    ];
    //les variable en commentaires n'ont aucune utilité à part pour simplifier utilisation au dev
}