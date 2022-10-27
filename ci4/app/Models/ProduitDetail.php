<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitDetail extends Model
{
    protected $table      = 'sae3.produit_detail';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = \App\Entities\ProduitDetail::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['intitule', 'prixttc','lienimage','isaffiche','description','stock'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}