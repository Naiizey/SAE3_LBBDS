<?php

namespace App\Models;

use CodeIgniter\Model;

Class ImportCSV extends Model{
    protected $table = "sae3.produitcsv";
    protected $primaryKey = "id_prod";



    protected $allowedFields = ["intitule_prod",
                                "prix_ht",
                                "prix_ttc",
                                "description_prod",
                                "lien_image_prod",
                                "publication_prod",
                                "stock_prod",
                                "moyenne_note_prod",
                                "seuil_alerte_prod",
                                "alerte_prod",
                                "code_sous_cat"];

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
        $dicoFields = ["intitule_prod" => "integer",
                                "intitule_prod" => "varchar(50)",
                                "prix_ht" => "float8",
                                "prix_ttc" => "float8",
                                "description_prod" => "varchar",
                                "lien_image_prod" => "varchar",
                                "publication_prod" => "boolean",
                                "stock_prod" => "float8",
                                "moyenne_note_prod" => "Pays",
                                "seuil_alerte_prod" => "integer",
                                "alerte_prod" => "boolean",
                                "code_sous_cat" => "integer"];
        return $dicoFields;
    }
}