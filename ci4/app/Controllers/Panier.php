<?php namespace App\Controllers;

class Panier extends BaseController
{
    public function index()
    {
        return view('panier/index.php');
    }

    public function test()
    {
        echo "Hello World";
    }

    public function verification(){
        $auth = service('authentification');
        $verif=$auth->connexion($this->request->getPost()); 
        if($verif){
            return redirect()->to("/");
        }
        else{
            return redirect()->to("/connexion/400");
        }
        
    }

    // fonction qui permet de récupérer les produits du panier
    public function getProduitsPanier(){
        $session = session();
        $panier = $session->get('panier');
        $produits = array();
        $produitModel = model("\App\Models\Produit");
        foreach($panier as $idProduit => $quantite){
            $produit = $produitModel->find($idProduit);
            $produit->quantite = $quantite;
            $produits[] = $produit;
        }
        return $produits;
    }

    public function getProduitPanierClient($context = null)
    {
        $data['controller']= "panier";
        if($context == 400)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }

        $data['produits'] = model("\App\Models\ProduitPanierModel")->findAll();
        
        return view('page_accueil/panier.php', $data);
    }
}