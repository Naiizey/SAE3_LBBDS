<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientAdresseFacturation extends Model{
    protected $table = "sae3.adresse_facturation";
    protected $primaryKey = "num_compte";

    protected $allowedFields = ["num_compte",
                                "nom_a",
                                "prenom_a",
                                "numero_rue",
                                "nom_rue",
                                "code_postal",
                                "ville",];

    protected $returnType = \App\Entities\AdresseFacturation::class;

    public function getAdresse($id){
        return $this->where('num_compte',$id)->findAll();
    }
}