<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AdresseLivraison extends Entity{
    public function __toString()
    {
        return '<div class="numNameFirstName"><h5>Nom: '.$this->nom_a.'</h5><h5>Prenom: '.$this->prenom_a.'</h5></div>'
        .'<div class="numStreetName"><h5>Adresse: '.$this->numero_rue.'</h5><h5>'.$this->nom_rue.'</h5></div>'
        .'<div class="postalCodeCity"><h5>Ville: '.$this->code_postal.'</h5><h5>'.$this->ville.'</h5></div>';
    }
}