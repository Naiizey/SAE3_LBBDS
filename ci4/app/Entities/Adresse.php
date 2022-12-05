<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Adresse extends Entity
{
    protected $attributes = [
        "nom" => "",
        "prenom" => "",
        "numero_rue" => "",
        "nom_rue" => "",
        "nom_a" => "",
        "code_postal" => "",
        "ville" => "",
        "comp_a1" => "",
        "comp_a2" => "",
        "infos_comp" => ""

    ];

    protected $datamap = [
        "c_adresse1" => "comp_a1",
        "c_adresse2" => "comp_a2"
    ];
    

    public function get($what){
        if (in_array($what,array_keys($this->attributes))){
            return htmlspecialchars($this->$what);
        }
    }

    public function getAll()
    {
        return array('<p>Nom : '.$this->nom.'</p>', 
                     '<p>Prenom : '.$this->prenom.'</p>',
                     '<p>Adresse : '.$this->numero_rue.'</p>',
                     '<p>Nom de rue : '.$this->nom_rue.'</p>',
                     '<p>Ville : '.$this->ville.'</p>',
                     '<p>Code postal : '.$this->code_postal.'</p>');
    }

    public function checkAttribute(\CodeIgniter\Validation\Validation $validator){
        return $validator->run($this->attributes);
    }
}
