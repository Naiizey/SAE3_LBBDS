<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CommandeVend extends Entity
{
  public function etatString() : String
  {
      switch ($this->etat) {
         case 1:
            return 'En attente';
            break;
         case 2:
            return 'En route';
            break;
         case 3:
            return 'En route';
            break;
         case 4:
            return 'En route';
            break;
         case 5:
            return 'Livrée';
            break;
         default:
            return 'Erreur';
            break;
      }
  }
}
