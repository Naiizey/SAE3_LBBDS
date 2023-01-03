<?php

namespace App\Models;

use CodeIgniter\Model;

Class ImportCSV extends Model{
    protected $table = "sae3.produitcsv";
    protected $primaryKey = "id_prod";



    protected $returnType = \App\Entities\Produit::class;

    function CSVImport($fileArray){
        foreach($fileArray as $value){
                $this->insert($value);
        }
    }

    /** 
        *   Fonction qui permet de récupérer le nom des colonnes de la table
        *   @return array
    */
    function getentete(){
        $entete = $this->db->getFieldNames($this->table);
        return $entete;
    }
}