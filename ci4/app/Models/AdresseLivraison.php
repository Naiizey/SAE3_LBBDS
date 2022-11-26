<?php

namespace App\Models;

use CodeIgniter\Model;
use Generator;

/** 
 * Model de classe client qui permet de récuperer un client, ainsi qu'insérer et mettre à jour.
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Client
 */
class AdresseLivraison extends Model
{
    protected $table      = 'sae3.adresse_livraison';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Adresse::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ["nom", "prenom", "numero_rue","nom_rue", "nom_a", "code_postal", "ville", "comp_a1", "comp_a2", "infos_comp"];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


   




   
}