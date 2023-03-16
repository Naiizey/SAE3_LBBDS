<?php

namespace App\Models;

use \App\Entities\Avis;
use CodeIgniter\Model;
use Exception;

/**
 * Accès aux avis
 * 
 *  Données:
 *      * notation: **CR**-- 
 *      * commentaire: **CR**-- 
 */
class LstAvis extends Model
{
    protected $table      = 'sae3.commentaires';
    protected $primaryKey = 'num_avis';
    protected $useAutoIncrement = true;

    protected $returnType     = Avis::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_avis', 'contenu_av', 'date_av', 'id_note', 'id_prod', 'num_compte', 'note_prod','pseudo'];

        
    /**
     * Accès à un avis depuis un produit
     *
     * @param $num_produit $num_produit [explicite description]
     *
     * @return array
     */
    public function getAvisByProduit($num_produit) : array
    {
        return $this->where('id_prod',$num_produit)->findAll();
    }

    
    /**
     * Accès à un avis
     *
     * @param $num_avis $num_avis [explicite description]
     *
     * @return App\Models\LstAvis
     */
    public function getAvisById($num_avis) : \App\Models\LstAvis
    {
        return $this->where('num_avis',$num_avis)->first();
    }
    
    /**
     * Création de l'avis dans la base
     *
     * @param Avis $avis Avis à enregistrer
     *
     * @return void
     */
    public function enregAvis(Avis $avis)
    {
        $this->save($avis);
    }
}