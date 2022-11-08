<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Produit extends Entity
{

   public $datamap= [
      #id,
      #intitule,
      'prixTtc' => 'prixttc',
      'lienImage' => 'lienimage',
      #categorie
      'moyenneNote' => 'moyennenote'
  ];

   public function __toString()
   {
    return "Id: $this->id, Intitule: $this->intitule";
   }
}
