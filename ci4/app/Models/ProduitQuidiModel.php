<?php

namespace App\Models;

use \App\Entities\ProduirtQuidi as Produit;

use CodeIgniter\Model;
use Exception;

abstract class ProduitQuidiModel extends Model
{
    /*
    protected $table      = 'sae3.produit_panier_compte';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_prod','quantite','num_client'];
    */
    protected $returnType     = Produit::class;


    abstract protected function getIdVendeur();
    abstract protected function getColonneProduitIdVendeur();

    public function getQuidi($idVendeur)
    {
        return $this->where($this->getIdVendeur(),$idVendeur)->findAll();
    }

    public function deleteFromQuidi($idProd,$numVnd)
    {
        return $this->where($this->getIdVendeur(),$numVnd)->where('id_prod',$idProd)->delete();
    }

    public function viderQuidi($idVendeur)
    {
        foreach($this->getQuidi($idVendeur) as $prod){
            $this->delete($prod->id);
        }
        
    }


    public function ajouterProduit($idProd,$idVendeur, $siDejaLaAjoute=false)
    {
      
     
        $prod=model("\App\Models\ProduitDetail")->find($idProd)->convertForQuidi();
        $trouve=$this->where($this->getIdVendeur(),$idVendeur)->where("id_prod",$prod->idProd)->findAll();
        if(!empty($trouve) && $siDejaLaAjoute)
            throw new Exception("Produit déjà présent dans le quidi, ajout ignoré",400);
     
        if($prod->numVnd != $idVendeur)
            throw new Exception("Vous n'êtes pas autorisé a catalogué un produit qui appartient à un autre vendeur",401);
      
        
        #FIXME: La vue MVC peut créer cette exception
        $prod->id="&";
        $this->save($prod);
       
    }
}