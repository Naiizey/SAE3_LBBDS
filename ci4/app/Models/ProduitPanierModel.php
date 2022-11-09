<?php

namespace App\Models;

use \App\Entities\Produit as Produit;

use CodeIgniter\Model;


class ProduitPanierModel extends Model
{
    protected $table      = 'sae3.produit_panier';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','quantite','num_client'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;



    public function getPanierFromClient($numCli)
    {
        return $this->where('num_client',$numCli)->findAll();
    }

    public function deleteFromPanier(Produit $prod,$numCli)
    {
        return $this->where('num_client',$numCli)->delete($this->id);
    }

    public function viderPanier(Produit $prod,$numCli)
    {
        foreach($this->getPanierFromClient($numCli) as $prod){
            $this->delete($prod,$numCli);
        }
    }

    public function ajouterProduit(Produit $prod,$numCli)
    {
        
    }

    public function changerQuantite(Produit $prod,$numCli){
        
    }

}