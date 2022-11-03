<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Client extends Entity
{
    public function __toString()
    {
        return "<p>$this->identifiant</p>Nom: $this->nom\tPrénom: $this->prenom";
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
