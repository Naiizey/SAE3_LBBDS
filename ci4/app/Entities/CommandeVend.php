<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class CommandeVend extends Entity
{
  public function etatString() : String
  {
      switch ($this->etat) {
         case 0:
            return 'En attente';
            break;
         case 1:
            return 'En route';
            break;
         case 2:
            return 'Livrée';
            break;
         case 3:
            return 'Annulée';
            break;
         case 4:
            return 'Retour';
            break;
         case 5:
            return 'Terminée';
            break;
         default:
            return 'Erreur';
            break;
      }
  }
}
