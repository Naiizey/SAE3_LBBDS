<?php namespace App\Entities;

use App\Services\LBBDPconstants;
use CodeIgniter\Entity\Entity;

class Commande extends Entity implements LBBDPconstants
{


    protected $datamap = [
        'id'=>'num_commande',
        'num_commande'=>'num_commande',
        'identifiant'=>'num_commande',
        'dateCommande'=>'date_commande', 
        'dateReg'=>'date_plateformereg', 
        'dateLoc'=>'date_plateformeloc',
        'dateArriv'=>'date_arriv'
    ];

    public function etatString() : String
    {
       if(is_string($this->etat) && $this->etat == "0123456789"){
            return $this->etat;
       }else{
            return self::STRING_ETAT[$this->etat];
       }
    }

    public function getEtatNum() : int 
    {
        if(is_int($this->etat)){
            return $this->etat;
       }else if($this->etat == "0123456789"){
            return intval($this->etat);
       }else{
            return array_flip(self::STRING_ETAT)[$this->etat];
       }
    }
}
