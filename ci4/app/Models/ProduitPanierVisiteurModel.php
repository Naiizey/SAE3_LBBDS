<?php

namespace App\Models;

use \App\Entities\ProduitPanier as Produit;

use CodeIgniter\Model;
use Exception;

class ProduitPanierVisiteurModel extends ProduitPanierModel
{
    protected $table      = 'sae3.produit_panier_visiteur';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = false;

    protected $returnType     = Produit::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_prod','quantite','token_cookie'];


    protected function getIdUser(){
        return 'token_cookie';
    }

    protected function getColonneProduitIdUser(){
        return 'tokenId';
    }


    public function createPanierVisiteur($token,$expiration){
        
        $date = date('Y-m-d H:i:s',$expiration); 

        $db = db_connect();
        $db->table('sae3._panier_visiteur')->insert(array('date_suppression'=>$date,'token_cookie'=>$token));

        return $token;
    } 

   
    

}