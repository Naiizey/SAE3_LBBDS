<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;
use Exception;

/**
 * Permet d'intéragir avec un panier 
 *  Données:
 *      * produit panier: **CRUD**
 *      
 */
abstract class ProduitPanierModel extends Model
{
   
    protected $returnType     = Produit::class;

     /**
     * Récupération du champ du panier dans la BDD qui permet d'identifié un panier.
     *
     * @return string
     */
    abstract protected function getIdUser() : string;
    /**
     * Récupération du champ d'un objet panier qui permet d'identifié un panier.
     *
     * @return string
     */
    abstract protected function getColonneProduitIdUser() : string;

        
    /**
     * Récupération des produits d'un panier
     *
     * @param $idUser $idUser numéro rélié au panier
     *
     * @return array \App\Entities\ProduitPanier
     */
    public function getPanier($idUser)  
    {
        return $this->where($this->getIdUser(),$idUser)->findAll();
    }

        
    /**
     * Suppression d'un produit du panier
     *
     * @param $idProd $idProd identifiant du produit
     * @param $numCli $numCli numéro relié au panier
     *
     * @return void
     */
    public function deleteFromPanier($idProd,$numCli)
    {
        return $this->where($this->getIdUser(),$numCli)->where('id_prod',$idProd)->delete();
    }
    
    /**
     * Vide les produits d'un panier
     *
     * @param $idUser $idUser numéro relié au panier
     *
     * @return void
     */
    public function viderPanier($idUser)
    {
        foreach($this->getPanier($idUser) as $prod){
            $this->delete($prod->id);
        }
        
    }

    
    /**
     * Ajoute un produit au panier
     *
     *
     * @param $idProd $idProd numéro du produit à ajouter
     * @param $quantite $quantite quantité du produit à ajouteer (>0)
     * @param $idUser $idUser identifiant rélié au panier
     * @param $siDejaLaAjoute=false $siDejaLaAjoute indique si l'ajout est possible même si le produit est déjà dans le panier
     *
     * @return void
     */
    public function ajouterProduit($idProd,$quantite,$idUser, $siDejaLaAjoute=false)
    {
        if($quantite==0){
            throw new Exception("Impossible d'ajouter une quantité nulle");
        }
        $colonne=$this->getColonneProduitIdUser();
        $prod=model("\App\Models\ProduitDetail")->find($idProd)->convertForPanier();
        $prod->quantite=$quantite;
        $prod->$colonne=$idUser;
        $trouve=$this->where($this->getIdUser(),$prod->$colonne)->where("id_prod",$prod->idProd)->findAll();
        if(empty($trouve))
        {
            $prod->id="£";
            #FIXME: La vue front peut créer cette exception -> faire le reassort
            if($prod->quantite > $prod->stock) throw new Exception("Il n'y a pas assez de stock pour ajouter $prod->quantite produits",400);
            $this->save($prod);

        }
        else if ($siDejaLaAjoute)
        {
            $dejaLa=new Produit();
            $dejaLa=$trouve[0];

            $dejaLa->quantite+=(int)$prod->quantite;
            if($dejaLa->quantite > $dejaLa->stock) throw new Exception("Il n'y a pas assez de stock pour ajouter $dejaLa->quantite produits",400);
            $this->save($dejaLa);
        }
        else throw new Exception("Produit déjà présent dans le panier, ajout ignoré",400);
    }

    
    /**
     * Change la quantité d'un produit dans le panier
     *
     * @param $id $id identifiant du produit
     * @param $idUser $idUser numéro relié au panier
     * @param $newQuanite $newQuanite nouvelle quantité
     *
     * @return void
     */
    public function changerQuantite($id,$idUser,$newQuanite){
        $prod=$this->where($this->getIdUser(),$idUser)->find($id);
        if($prod != null){
            $prod->fill(array('id'=>$id,'quantite'=>$newQuanite,$this->getIdUser()=>$idUser));
            $this->save($prod);
        }
        else throw new Exception("Ce produit n'est pas dans le panier");
        
    }   

        
    /**
     * Récupération de la quantité d'un produit d'un panier
     *
     * @param $idProd $idProd identifiant d'un produit
     * @param $idUser $idUser numéro rélié au panier
     *
     * @return void
     */
    public function getQuantiteProduitByIdProd($idProd,$idUser){
        $retour =$this->where($this->getIdUser(),$idUser)->where('id_prod',$idProd)->findAll();
        return (empty($retour))?0:$retour[0]->quantite;
    }
    
    /**
     * Total des unités de produit dans le panier
     *
     * @param $idUser $idUser [explicite description]
     *
     * @return void
     */
    public function compteurDansPanier($idUser){
        $retour = $this->where($this->getIdUser(),$idUser)->selectSum('quantite','countPanier')->first();
        return (is_null($retour))?0:$retour->countPanier;
    }

}