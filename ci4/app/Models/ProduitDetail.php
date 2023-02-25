<?php

namespace App\Models;

use CodeIgniter\Model;


/** 
 * Model de classe Produit le plus détaillé pour un accès aux clients.
 * Read-only ?
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Client
 */

class ProduitDetail extends Model
{
    protected $table      = 'sae3.produit_detail';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = \App\Entities\ProduitDetail::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['intitule', 'prixttc', 'prixht', 'lienimage','isaffiche','description','stock'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false; 
}