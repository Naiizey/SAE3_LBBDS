<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProduitPanier extends Entity
{

   public $datamap= [
      #id,
      'idProd' => 'id_prod',
    
      'prixTtc' => 'prixttc',
      'prixHt' => 'prix_ht',
      'lienImage' => 'lienimage',

      
      'tokenId' => 'token_cookie',
      'numCli'=> "num_client"
  ];

   public function __toString()
   {
    return "Id: $this->id, Intitule: $this->intitule";
   }
}
