<?php namespace App\Entities;



class ProduitDetail extends Produit
{
    public $datamap = [
        "numVnd" => "num_vendeur"
    ];   

    public function convertForPanier()
    {
        $retour=new ProduitPanier();
        $retour->idProd=$this->id;
        $retour->stock=$this->stock;

        return $retour;

    }

    public function convertForQuidi()
    {

        $retour=new ProduitQuidi();
        $retour->idProd=$this->id;
        $retour->numVnd=$this->numVnd;

        return $retour;

    }
}
