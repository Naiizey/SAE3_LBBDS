<?php

namespace App\Models;

use \App\Entities\Commentaires as Commentaires;
use CodeIgniter\Model;
use Exception;

class DetailsCommande extends Model
{
    protected $table      = 'sae3.commentaires';

    protected $useAutoIncrement = true;

    protected $returnType     = DetailsCommande::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_avis', 'contenu_av', 'date_av', 'id_note', 'id_prod', 'num_compte', 'note_prod','pseudo'];

    public function getCommentairesByProduit($num_produit){
        return $this->where('id_prod',$num_produit)->findAll();
    }
}