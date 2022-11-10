<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProduitPanier extends Entity
{

   public $datamap= [
      #id,
      'idProd' => 'id_prod',
    
      'prixTtc' => 'prixttc',
      'lienImage' => 'lienimage',
   

      'numCli'=> "num_client"
  ];

   public function __toString()
   {
    return "Id: $this->id, Intitule: $this->intitule";
   }
}
