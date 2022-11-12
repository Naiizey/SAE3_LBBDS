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

    public function ajouterProduit(Produit $prod, $siDejaLaAjoute=false)
    {
        if($prod->quantite===0) throw new Exception("Pas d'ajout de produit à la quantité null");
        
        
        $trouve=$this->where("num_client",$prod->numCli)->where("id_prod",$prod->idProd)->findAll();
        if(empty($trouve))
        {
            $prod->id="£";
            #FIXME: La vue MVC peut créer cette exception
            if($prod->quantite > $prod->stock) throw new Exception("Pas assez de stock: $prod->quantite c'est trop");
            $this->save($prod);

        }
        else if ($siDejaLaAjoute)
        {
            $dejaLa=new Produit();
            $dejaLa=$trouve[0];

            $dejaLa->quantite+=$prod->quantite;
            if($dejaLa->quantite > $dejaLa->stock) throw new Exception("Pas assez de stock: $dejaLa->quantite c'est trop");
            $this->save($dejaLa);
        }
        else throw new Exception("Produit déjà présent dans le panier, et n'a pas été pris en compte");

        
    }

    public function changerQuantite($id,$numCli,$newQuanite){
        $prod=$this->where("num_client",$numCli)->find($id);

        if($prod != null){
            $prod->fill(array('id'=>$id,'quantite'=>$newQuanite,'num_client'=>$numCli));
            $this->save($prod);
        }
        else throw new Exception("Ce produit n'est pas dans le panier !");
        
        

        
    }   

}