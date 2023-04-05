<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class ProduitQuidi extends Entity
{

   public $datamap= [
      #id,
      'idProd' => 'id_prod',
      'prixttc' => 'prix_ttc',
      
      'intitule' => 'intitule_prod',

      'lienimage' => 'lien_image',
      
      'intitule' => 'intitule_prod',
      'prixHt' => 'prix_ht',

      'categorie' => 'libelle_cat',
      'moyenneNote' => 'moyenne_note_prod',
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
      $this->categorie=$this->categorie;
      $this->moyenneNote=$this->moyenneNote;
      $this->intitule=$this->intitule;
      return $this;
   }
}