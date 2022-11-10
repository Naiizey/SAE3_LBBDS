<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;
use Exception;

class ProduitPanierModel extends Model
{
    protected $table      = 'sae3.produit_panier_compte';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_prod','quantite','num_client'];




    public function getPanierFromClient($numCli)
    {
        return $this->where('num_client',$numCli)->findAll();
    }

    public function deleteFromPanier($idProd,$numCli)
    {
        return $this->where('num_client',$numCli)->where('id_prod',$idProd)->delete();
    }

    public function viderPanier($numCli)
    {
        
        
        foreach($this->getPanierFromClient($numCli) as $prod){
         
            $this->delete($prod->id);
        }
        
    }

    public function ajouterProduit(Produit $prod)
    {
     
        if(empty($this->where("num_client",$prod->numCli)->where("id_prod",$prod->idProd)->findAll())){
            $prod->id="£";
            $this->save($prod);

        }
        else throw new Exception("Ce produit est déjà dans le panier !".$this->where("num_client",$prod->numCli)->where("id_prod",$prod->idProd)->findAll()[0]);
        

        
    }

    public function changerQuantite($idProd,$numCli,$newQuanite){
        $prod=$this->where("num_client",$numCli)->where("id_prod",$idProd)->findAll()[0];
        if($prod != null){
            $prod->fill(array('id'=>$idProd,'quantite'=>$newQuanite,'num_client'=>$numCli));
            $this->save($prod);
        }
        else throw new Exception("Ce produit n'est pas dans le panier !");
        
        

        
    }   

}