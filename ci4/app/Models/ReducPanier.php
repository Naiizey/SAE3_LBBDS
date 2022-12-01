<?php

namespace App\Models;

use CodeIgniter\Model;


/** 
 * Model de classe des codes réductions
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\ReducPanier
 */
class ReducPanier extends Model
{
    protected $table      = 'sae3.reduc_panier';
    protected $primaryKey = 'num_panier, id_reduction';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\CodeReduction::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['num_panier','id_reduction'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function doesReducPanierExists($num_panier, $id_reduction)
    {
        return !empty($this->where('num_panier',$num_panier)->where('id_reduction', $id_reduction)->findAll());
    }
}