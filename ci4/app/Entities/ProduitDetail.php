<?php namespace App\Entities;



class ProduitDetail extends Produit
{
    public function convertForPanier()
    {
        $retour=new ProduitPanier();
        $retour->idProd=$this->id;
        $retour->stock=$this->stock;

        return $retour;

    }
}
