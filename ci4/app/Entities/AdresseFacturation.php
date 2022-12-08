<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class AdresseFacturation extends Entity
{
    public function get()
    {
        return array('<p>Nom : '.$this->nom_a.'</p>', 
                     '<p>Prénom : '.$this->prenom_a.'</p>',
                     '<p>Numéro de rue : '.$this->numero_rue.'</p>',
                     '<p>Nom de rue : '.$this->nom_rue.'</p>',
                     '<p>Ville : '.$this->ville.'</p>',
                     '<p>Code postal : '.$this->code_postal.'</p>');
    }
}