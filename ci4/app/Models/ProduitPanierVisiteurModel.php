<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;
use Exception;

class ProduitPanierModel extends Model
{
    protected $table      = 'sae3.produit_panier_visiteur';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_prod','quantite','token_panier'];




    public function getPanierFromToken($token)
    {
        return $this->where('token_panier',$token)->findAll();
    }

    public function deleteFromPanier($idProd,$token)
    {
        return $this->where('token_panier',$token)->where('id_prod',$token)->delete();
    }

    public function viderPanier($numCli)
    {
        
        
        foreach($this->getPanierFromClient($numCli) as $prod){
         
            $this->delete($prod->id);
        }
        
    }

    public function ajouterProduit(Produit $prod)
    {
     
        if(empty($this->where("token_panier",$prod->token)->where("id_prod",$prod->idProd)->findAll())){
            $prod->id="£";
            $this->save($prod);

        }
        else throw new Exception("Ce produit est déjà dans le panier !".$this->where("num_client",$prod->token)->where("id_prod",$prod->idProd)->findAll()[0]);
        

        
    }

    public function changerQuantite($idProd,$numCli,$newQuanite){
        $prod=$this->where("num_client",$numCli)->where("id_prod",$idProd)->findAll()[0];
        if($prod != null){
            $prod->fill(array('id'=>$idProd,'quantite'=>$newQuanite,'num_client'=>$numCli));
            $this->save($prod);
        }
        else throw new Exception("Ce produit n'est pas dans le panier !");
        
        

        
    }   

    public function creationPanier(){
        //TODO: faire le token et la date, :) bonne chance
        $date="";
        $token="";
        $db= \Config\Database::connect();
        $db->table("sae3._panier_visiteur")->insert(array("date_suppression"=>$date,"token_cookie"=>$token));
    }
    
    

}