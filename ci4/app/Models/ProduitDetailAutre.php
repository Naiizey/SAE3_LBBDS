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

class ProduitDetailAutre extends Model
{
    protected $table      = 'sae3.autre_image';

    protected $useAutoIncrement = false;

    protected $returnType     = \App\Entities\ProduitDetail::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['lien_image'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false; 

    public function getAutresImages($idProduit) : array
    {
        return $this->where('id_prod',$idProduit)->findAll();
    }
}
