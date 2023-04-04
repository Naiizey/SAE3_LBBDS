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

   public function convertForQuidi(){
      $this->idProd=$this->id;
      $this->prixTtc=$this->prixTtc;
      $this->prixHt=$this->prixHt;
      $this->lienImage=$this->lienImage;
      $this->numVnd=$this->numVnd;
      return $this;
   }

}