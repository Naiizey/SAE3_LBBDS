<?php

namespace App\Models;

use \App\Entities\ProduirtQuidi as Produit;

use CodeIgniter\Model;
use Exception;

use function PHPUnit\Framework\isNull;

abstract class ProduitQuidiModel extends Model
{

    protected $returnType     = Produit::class;




    //Ajout de l'id vendeur dans la requête si celui-ci est indiqué en paramètres
    abstract protected function whereSiVendeur($idVendeur);

    public function getQuidi($idVendeur)
    {
        return $this->whereSiVendeur($idVendeur)->findAll();
    }

    public function deleteFromQuidi($idProd,$numVnd)
    {
        return $this->whereSiVendeur($numVnd)->where('id_prod',$idProd)->delete();
    }

    public function viderQuidi($idVendeur)
    {
        foreach($this->getQuidi($idVendeur) as $prod){
            $this->delete($prod->id);
        }
        
    }


    public function ajouterProduit($idProd,$idVendeur, $siDejaLaAjoute=false)
    {
      
     
        $prod=model("\App\Models\ProduitDetail")->find($idProd)->convertForQuidi();
        $trouve=$this->whereSiVendeur($idVendeur)->where("id_prod",$prod->idProd)->findAll();
        if(!empty($trouve) && $siDejaLaAjoute)
            throw new Exception("Produit déjà présent dans le quidi, ajout ignoré",400);
     
        if($prod->numVnd != $idVendeur)
            throw new Exception("Vous n'êtes pas autorisé a catalogué un produit qui appartient à un autre vendeur",401);
      
        
        #FIXME: La vue MVC peut créer cette exception
        $prod->id="&";//Juste pour indiqué l'insertion au framework"
        $this->save($prod);
       
    }
}