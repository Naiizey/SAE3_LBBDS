<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;
use Exception;

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

    public function deleteFromPanier($idProd,$numCli)
    {
        return $this->where('num_client',$numCli)->delete($idProd);
    }

    public function viderPanier($numCli)
    {
        foreach($this->getPanierFromClient($numCli) as $prod){
            $this->delete($prod,$numCli);
        }
    }

    public function ajouterProduit($idProd,$quantite,$numCli)
    {
        if($this->find($idProd) == null){
            $prod=new Produit();
            $prod->fill(array('id'=>$idProd,'quantite'=>$quantite,'num_client'=>$numCli));
            $this->save($prod);

        }
        else throw new Exception("Ce produit est déjà dans le panier !");
        

        
    }

    public function changerQuantite($idProd,$numCli,$newQuanite){
        $prod=$this->find($idProd);
        if($prod != null){
            $prod->fill(array('id'=>$idProd,'quantite'=>$newQuanite,'num_client'=>$numCli));
            $this->save($prod);
        }
        else throw new Exception("Ce produit n'est pas dans le panier !");
        
        

        
    }   

}