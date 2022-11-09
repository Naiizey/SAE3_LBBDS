<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProduitPanier extends Entity
{

   public $datamap= [
      #id,
      #intitule,
      'prixTtc' => 'prixttc',
      'lienImage' => 'lienimage',
      #categorie
      'moyenneNote' => 'moyennenote',
      'numCli'=> "num_client"
  ];

   public function __toString()
   {
    return "Id: $this->id, Intitule: $this->intitule";
   }
}
