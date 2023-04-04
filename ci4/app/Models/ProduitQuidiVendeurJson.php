<?php

namespace App\Models;

use \App\Entities\ProduitQuidi as Produit;
use \App\Models\ProduitQuidiModel;
use CodeIgniter\Model;
use Exception;

class ProduitQuidiVendeurJson Extends ProduitQuidiVendeur
{
    protected $table      = 'sae3.produit_quidi_vendeur_json';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id','id_prod','num_vendeur','intitule_prod','publication_prod','description_prod','libelle_cat','prix_ttc','lien_image','moyenne_note_prod'];


    protected function whereSiVendeur($idVendeur)
    {
        if(is_null($idVendeur))
            throw new Exception("Ne devrais pas avoir un id Vendeur null");
        return $this->where("num_vendeur",$idVendeur);
    }
}