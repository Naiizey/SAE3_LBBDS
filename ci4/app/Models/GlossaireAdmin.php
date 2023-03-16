<?php

namespace App\Models;
use CodeIgniter\Model;

class Glossaire extends Model
{
    protected $table = 'sae3.glossaire_admin';
    protected $primaryKey = 'id_quidi';
    protected $returnType = \App\Entities\Glossaire::class;
    protected $allowedFields = ['intitule_prod','prix_ht','prix_ttc',"description_prod","logo","note_vendeur", "pseudo", "numero_siret", "tva_intercommunautaire", "texte_presentation", "email", "numero_rue", "nom_rue", "code_postal", "lien_image", "num_image", "ville"];
}

?>