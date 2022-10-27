<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Produit extends Entity
{
   public function __toString()
   {
    return "Id: $this->id, Intitule: $this->intitule";
   }
}
