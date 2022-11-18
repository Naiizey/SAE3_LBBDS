<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AdresseLivraison extends Entity
{
    public function get()
    {
        return array('<p>Nom : '.$this->nom_a.'</p>', 
                     '<p>Prenom : '.$this->prenom_a.'</p>',
                     '<p>Adresse : '.$this->numero_rue.'</p>',
                     '<p>Nom de rue : '.$this->nom_rue.'</p>',
                     '<p>Ville : '.$this->ville.'</p>',
                     '<p>Code postal : '.$this->code_postal.'</p>');
    }
}