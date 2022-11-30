<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientAdresseLivraison extends Model{
    protected $table = "sae3.adresse_livraison_client";
    protected $primaryKey = "num_compte";

    protected $allowedFields = ["num_compte",
                                "nom_a",
                                "prenom_a",
                                "numero_rue",
                                "nom_rue",
                                "code_postal",
                                "ville",];

    protected $returnType = \App\Entities\AdresseLivraison::class;

    public function getAdresse($id){
        return $this->where('num_compte',$id)->findAll();
    }
}