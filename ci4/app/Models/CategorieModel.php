<?php

namespace App\Models;

use CodeIgniter\Model;


/**
 * Utile pour accéder aux différentes catégories
 *  Données:
 *      * categorie: -**R**-- 
 */
class CategorieModel extends Model
{
    protected $table      = 'sae3.categorie';
    protected $primaryKey = 'code_cat';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Categorie::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = [];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}