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
        if($context == 400)
        {
            $error= "Connexion refusé, identifiants inccorects";
            $data['error']="<div class='bloc-erreurs'>
                                <p class='paragraphe-erreur'>$error</p>
                            </div>";
        }
        else $data['error']="";
        

        return view('page_accueil/connexion.php',$data);
    }

    public function inscription()
    {
        $errors=session()->get('errors');
       
        //print_r($errors);
        #TODO: bcrypt 
        $data['controller']= "connexion";

        return view('page_accueil/inscription.php',$data);
    }

    public function produit($idProduit = null)
    {
        if($idProduit == null)
        {
            return view(
                'errors/html/error_404.php'
                , array('message' => "Pas de produit spécifier")
            );
        }
        $prodModel = model("\App\Models\ProduitDetail");
        $result = $prodModel->find($idProduit);
        if($result == null)
        {
            
            return view(
                'errors/html/error_404.php'
                , array('message' => "Ce produit n'existe pas")
            );
        }
        else
        {
            $data['controller']= "produit";

            $data['prod']=$result;
            return view('page_accueil/produit.php',$data);
        }
        #TODO: pensez à mettre le prix HT dans la vue html et aussi indiquer que la livraison est gratuite
        
        
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
        
        return view('page_accueil/panier.php',$data);
    }
}
