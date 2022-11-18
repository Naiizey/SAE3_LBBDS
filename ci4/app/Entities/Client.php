<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Client extends Entity
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
        return "<p>$this->identifiant</p>Nom: $this->nom\tPrénom: $this->prenom";
    }

    public function getPseudo(){
        return $this->identifiant;
    }

    public function getFirstName(){
        return $this->prenom;
    }

    public function getSurname(){
        return $this->nom;
    }

    public function getMail(){
        return $this->email;
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
        #nom
        #prenom
        #identifiant
        'identifiant' => 'identifiant',
        'pseudo' => 'identifiant'
    ];
    //les variable en commentaires n'ont aucune utilité à part pour simplifier utilisation au dev
}
