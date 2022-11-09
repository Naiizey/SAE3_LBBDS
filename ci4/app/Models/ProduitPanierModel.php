<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;


class ProduitPanierModel extends Model
{
    protected $table      = 'sae3.produit_panier';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','quantite','num_client'];




    public function getPanierFromClient($numCli)
    {
        return $this->where('num_client',$numCli)->findAll();
    }

    public function deleteFromPanier(Produit $prod,)
    {
        return $this->where('num_client',$prod->numCli)->delete($this->id);
    }

    public function viderPanier($numCli)
    {
        foreach($this->getPanierFromClient($numCli) as $prod){
            $this->delete($prod,$numCli);
        }
    }

    public function ajouterProduit(Produit $prod,$numCli)
    {
        if(isset($prod->id) && isset($prod->quantite) && isset($prod->numCli)){
            $this->save($prod);

        }
    }

    public function changerQuantite(Produit $prod,$numCli,$newQuanite){
        $prod->quantite=$newQuanite;
        if(isset($prod->id) && isset($prod->id) && isset($prod->numCli)){
            $this->save($prod);

        }
    }   

}