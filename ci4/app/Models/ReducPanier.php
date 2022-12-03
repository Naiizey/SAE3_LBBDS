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
    protected $primaryKey = 'num_panier';

    protected $useAutoIncrement = false;

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

    public function getReducByPanier($num_panier)
    {
        return $this->where('num_panier',$num_panier)->findAll();
    }
    public function associerCodeAPanier($num_panier, $id_reduction)
    {
        $reducPanier = new \App\Entities\ReducPanier();
        $reducPanier->num_panier = $num_panier;
        $reducPanier->id_reduction = $id_reduction;
        $this->save($reducPanier);
    }
    public function dissocierCodeAPanier($num_panier)
    {
        $this->where('num_panier',$num_panier)->delete();
    }
}