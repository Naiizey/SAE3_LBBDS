<?php

namespace App\Models;

use CodeIgniter\Model;


/** 
 * Model de classe des codes réductions
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\CodeReduction
 */
class CodeReduction extends Model
{
    protected $table      = 'sae3.code_reduction';
    protected $primaryKey = 'id_reduction';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\CodeReduction::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_reduction','code_reduction','montant_reduction','pourcentage_reduction','date_debut','heure_debut','date_fin','heure_fin'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getCodeReducByCode($code_reduction)
    {
        return $this->where('code_reduction',$code_reduction)->findAll();
    }

    public function getCodeReducById($id_reduction)
    {
        return $this->where('id_reduction',$id_reduction)->findAll();
    }
}