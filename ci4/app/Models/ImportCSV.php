<?php

namespace App\Models;

use CodeIgniter\Model;

Class ImportCSV extends Model{
    protected $table = "sae3.produitcsv";
    protected $primaryKey = "id_prod";

    protected $allowedFields = [
                                'intitule_prod',
                                'prix_ht',
                                'prix_ttc',
                                'description_prod',
                                'lien_image_prod',
                                'publication_prod',
                                'stock_prod',
                                'moyenne_note_prod',
                                'seuil_alerte_prod',
                                'alerte_prod',
                                'code_sous_cat'];

    protected $returnType = \App\Entities\Produit::class;

    function CSVImport($fileArray){
        foreach($fileArray as $value){
                $this->insert($value);
        }
    }
}