<?php

namespace App\Models;

use \App\Entities\Avis;
use CodeIgniter\Model;
use Exception;

class LstAvis extends Model
{
    protected $table      = 'sae3.commentaires';
    protected $primaryKey = 'num_avis';
    protected $useAutoIncrement = true;

    protected $returnType     = LstAvis::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_avis', 'contenu_av', 'date_av', 'id_note', 'id_prod', 'num_compte', 'note_prod','pseudo'];

    public function getAvisByProduit($num_produit) : array
    {
        return $this->where('id_prod',$num_produit)->findAll();
    }

    public function getAvisById($num_avis) : \App\Models\LstAvis
    {
        return $this->where('num_avis',$num_avis)->first();
    }

    public function enregAvis(Avis $avis)
    {
        $this->save($avis);
    }
}