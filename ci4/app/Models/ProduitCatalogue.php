<?php

namespace App\Models;

use CodeIgniter\Model;


/**
 * Model de classe produit
 * En Read-Only
 *
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Client
 */

class ProduitCatalogue extends Model
{
    protected $table      = 'sae3.produit_catalogue';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = \App\Entities\Produit::class;
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