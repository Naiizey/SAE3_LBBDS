<?php

namespace App\Models;

use CodeIgniter\Model;

class Produit extends Model
{
    protected $table      = 'produit_catalogue';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = \App\Entities\ProduitCatalogue::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['intitule', 'prixttc','lienimage','isaffiche'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}