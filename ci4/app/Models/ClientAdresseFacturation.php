<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Accéder aux adresses de facturation reliés à leurs client
 *  || | | | |
 *  | - | - | - | - | - |
 *  | **actions** | **Create** | **Read** | **Update** | **Delete** |
 *  |**possible**||X|||
 */
class ClientAdresseFacturation extends Model{
    protected $table = "sae3.adresse_facturation_client";
    protected $primaryKey = "num_compte";

    protected $allowedFields = ["num_compte",
                                "nom_a",
                                "prenom_a",
                                "numero_rue",
                                "nom_rue",
                                "code_postal",
                                "ville",];

    protected $returnType = \App\Entities\AdresseFacturation::class;


    
    /**
     * Method getAdresse
     *
     * @param _ $id numero d'un client
     *
     * @return void
     */
    public function getAdresse($id){
        return $this->where('num_compte',$id)->findAll();
    }
}