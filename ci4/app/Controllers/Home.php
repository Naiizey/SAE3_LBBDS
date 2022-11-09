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
            $error = "Connexion refusée, identifiant et ou mot de passe incorrects";
            $data['erreur']="<div class='bloc-erreurs'>
                                <p class='paragraphe-erreur'>$error</p>
                            </div>";
        }
        else $data['erreur']="";
        

        return view('page_accueil/connexion.php',$data);
    }

    public function inscription()
    {
        $post=$this->request->getPost();
        $issues=[];
        if(!empty($post)){
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->inscription($user,$post['confirmezMotDePasse']); 

            if(empty($issues)) {
                return redirect()->to("/");
            }
        }
       
        //print_r($errors);

        $data['controller']= "inscription";
        $data['erreurs'] = $issues;
        //print_r($issues);
        return view('page_accueil/inscription.php',$data);
    }

    public function produit($idProduit = null)
    {
        if($idProduit == null)
        {
            return view(
                'errors/html/error_404.php'
                , array('message' => "Pas de produit spécifié")
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

    private const NBPRODSPAGECATALOGUE = 10;
    #FIXME: comportement href différent entre $page=null oe $page !=null    

    public function catalogue($page=null){
        $get=$this->request->getGet();
        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $data['controller']="Catalogue";
        
        $data['nombreMaxPages']=sizeof($data['prods']) % self::NBPRODSPAGECATALOGUE;
        if(is_null($page) || $page==0)
        {
            $data['minProd']=0;
            $data['maxProd']=self::NBPRODSPAGECATALOGUE;
            $data['page']=1;
        }
        else
        {
            if($data['nombreMaxPages']>=$page)
            {
                $data['page']=$page;

                $data['minProd']=self::NBPRODSPAGECATALOGUE*$page;
                $data['maxProd']=self::NBPRODSPAGECATALOGUE*($page+1);
                
            }
            else return view(
                'errors/html/error_404.php'
                , array('message' => "Page trop haute: pas assez de produit")
                );
            
                
            
            
            
        }
        

        return view("catalogue.php",$data);
    }
    public function import()
    {
        $data['controller']= "import";
        $strJsonFileContents = file_get_contents("ressources/data.json");
        $array = json_decode($strJsonFileContents, true);
        if($array[0]['alerte_prod'])    // suggested by **mario**
        {
            echo "alerte";
            $array[0]['alerte_prod'] = "1";
        }
        else {
            echo "pas alerte";
            $array[0]['alerte_prod'] = "0";   
        }
        if($array[0]['publication_prod'])    // suggested by **mario**
        {
            echo "publié";
            $array[0]['publication_prod'] = "1";    
        }
        else {
            echo "pas publié";
            $array[0]['publication_prod'] = "0";   
        }
        print_r($array);
        $importModel = model("\App\Models\ImportCSV");
        $importModel->CSVimport($array);
        return view('page_accueil/import.php', $data);
    }
}
