<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProduitQuidi extends Entity
{

   public $datamap= [
      #id,
      'idProd' => 'id_prod',
    
      'prixTtc' => 'prixttc',
      'prixHt' => 'prix_ht',
      'lienImage' => 'lienimage',

      'numVnd'=> "num_vendeur"
  ];

   public function __toString()
   {
    return "Id: $this->id, Intitule: $this->intitule";
   }
}