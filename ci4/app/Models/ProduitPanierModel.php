<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;
use Exception;

abstract class ProduitPanierModel extends Model
{
    /*
    protected $table      = 'sae3.produit_panier_compte';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_prod','quantite','num_client'];
    */
    protected $returnType     = Produit::class;


    abstract protected function getIdUser();
    abstract protected function getColonneProduitIdUser();

    public function getPanier($idUser)
    {
        return $this->where($this->getIdUser(),$idUser)->findAll();
    }

    public function deleteFromPanier($idProd,$numCli)
    {
        return $this->where($this->getIdUser(),$numCli)->where('id_prod',$idProd)->delete();
    }

    public function viderPanier($idUser)
    {
        
        
        foreach($this->getPanier($idUser) as $prod){
         
            $this->delete($prod->id);
        }
        
    }


    public function ajouterProduit($idProd,$quantite,$idUser, $siDejaLaAjoute=false)
    {
        if($quantite==0){
            throw new Exception("Pas d'ajout de produit à la quantité null");
        }
        
        $colonne=$this->getColonneProduitIdUser();
        
        $prod=model("\App\Models\ProduitDetail")->find($idProd)->convertForPanier();
        $prod->quantite=$quantite;
        $prod->$colonne=$idUser;
        
        $trouve=$this->where($this->getIdUser(),$prod->$colonne)->where("id_prod",$prod->idProd)->findAll();
        
        if(empty($trouve))
        {
            $prod->id="£";
            #FIXME: La vue MVC peut créer cette exception
            if($prod->quantite > $prod->stock) throw new Exception("Pas assez de stock: $prod->quantite c'est trop",400);
            $this->save($prod);

        }
        else if ($siDejaLaAjoute)
        {
            $dejaLa=new Produit();
            $dejaLa=$trouve[0];

            $dejaLa->quantite+=(int)$prod->quantite;
            if($dejaLa->quantite > $dejaLa->stock) throw new Exception("Pas assez de stock: $dejaLa->quantite c'est trop",400);
            $this->save($dejaLa);
        }
        else throw new Exception("Produit déjà présent dans le panier, et n'a pas été pris en compte",400);

        
    }


    public function changerQuantite($id,$idUser,$newQuanite){
        $prod=$this->where($this->getIdUser(),$idUser)->find($id);

        if($prod != null){
            $prod->fill(array('id'=>$id,'quantite'=>$newQuanite,$this->getIdUser()=>$idUser));
            $this->save($prod);
        }
        else throw new Exception("Ce produit n'est pas dans le panier !");
        
    }   

    public function compteurDansPanier($idUser){
        return $this->where($this->getIdUser(),$idUser)->selectSum('quantite','countPanier')->groupBy('id')->first()->countPanier;
    }

}