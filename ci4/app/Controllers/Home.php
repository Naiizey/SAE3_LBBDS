<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['controller']= "index";
        return view('page_accueil/index.php',$data);
    }

    public function connexion($context = null)
    {
        $data['controller']= "connexion";
        if($context == 400){
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        $clientModel = model("\App\Models\Client");
        $data['prod'] = $clientModel->find(1);
        return view('page_accueil/connexion.php',$data);
    }

    public function inscription($context = null)
    {
        $data['controller']= "connexion";
        if($context == 400)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        $clientModel = model("\App\Models\Client");
        $data['prod'] = $clientModel->find(1);
        return view('page_accueil/inscription.php',$data);
    }

    public function produit($idProduit = null)
    {
        $data['controller']= "produit";
        if($idProduit == null)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        $clientModel = model("\App\Models\ProduitDetail");
        $result = $clientModel->find($idProduit);
        if($result == null)
        {
            
            return view(
                'errors/html/error_404.php'
                , array('message' => "Ce produit n'existe pas")
            );
        }
        else
        {
            
            $data['prod']=$result[0];
            return view('page_accueil/produit.php',$data);
        }
        #TODO: pensez à mettre le prix HT dans la vue et aussi indiquer que la livraisin est gratuite
        
        
    }

    public function panier($context = null)
    {
        $data['controller']= "panier";
        if($context == 400)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        
        return view('page_accueil/panier.php',$data);
    }

    public function panierVide($context = null)
    {
        $data['controller']= "panierVide";
        if($context == 400)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        
        return view('page_accueil/panierVide.php',$data);
    }
}
