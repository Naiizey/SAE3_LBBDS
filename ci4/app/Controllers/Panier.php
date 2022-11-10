<?php namespace App\Controllers;

use Exception;

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
    /*
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
    */

    public function getProduitPanierClient($context = null)
    {
        $data['controller']= "panier";
        if($context == 400)
        {
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        else{
            $data['produits'] = model("\App\Models\ProduitPanierModel")->getPanierFromClient(session()->get("numero"));

        }
        
    
        
        return view('page_accueil/panier.php', $data);
    }

    public function viderPanier() {
   
        if(session()->has("numero"))
        {
            $panierModel = model("\App\Models\ProduitPanierModel");
            $panierModel->viderPanier(session()->get("numero"));
        }
        else if(cookies()->has("token_panier"))
        {
            //TODO: vider en tant qu'internautes
        }
        else throw new \Exception("Le panier n'existe pas !");
        
        
        
        return redirect()->to("panier");
    }

    /*
    public function ajouterPanier() {
        $data['controller'] = "panier";
        $session = session();
        $panier = $session->get('panier');
        $idProduit = $this->request->getPost('idProduit');
        $quantite = $this->request->getPost('quantite');
        if($panier == null) {
            $panier = array();
        }
        if(array_key_exists($idProduit, $panier)) {
            $panier[$idProduit] += $quantite;
        } else {
            $panier[$idProduit] = $quantite;
        }
        $session->set('panier', $panier);
        $panierModel = model("\App\Models\ProduitPanierModel");
        $panierModel->ajouterProduitPanier($idProduit, $quantite);
        return view('page_accueil/panier.php', $data);
    }
    */

    public function ajouterPanier($idProd=null,$quantite=null) {
        $data['controller'] = "panier";
        
       if(!is_null($idProd) && !is_null($quantite))
       {
            if(session()->has("numero"))
            {
                $prod=new \App\Entities\ProduitPanier();
                $prod->idProd = $idProd;
                $prod->quantite  = $quantite;
                $prod->numCli= session()->get("numero");
                $panierModel = model("\App\Models\ProduitPanierModel");
                $panierModel->ajouterProduit($prod);
            }
            else if(cookies()->has("token_panier"))
            {
                //TODO: vider en tant qu'internautes
            }
            else 
            {
                //TODO: création du panier
                //temporaire:
                throw new \Exception("Non implémenté");
            }

            
       }
       
        
    
    }

    public function supprimerProduitPanier($idProd = null){
        if(!is_null($idProd))
        {
            if(session()->has("numero"))
            {
                $panierModel = model("\App\Models\ProduitPanierModel");
                $panierModel->deleteFromPanier($idProd,session()->get("numero"));
            }
            else if(cookies()->has("token_panier"))
            {
                //TODO: vider en tant qu'internautes
            }
            else throw new \Exception("Le panier n'existe pas !");
        }
        if(isset($this->request)){
            return redirect()->to(session()->get("_ci_previous_url"));
        }
    }
}