<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function __construct()
    {
        //permer d'éviter le bug de redirection.
        session();

    }

    public function index()
    {
        $data['controller']= "index";

        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
 
        return view('page_accueil/index.php',$data);
    }

    public function connexion()
    {
        $post=$this->request->getPost();
        $issues=[];

        if(!empty($post))
        {
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->connexion($user); 

            if(empty($issues)) 
            {
                return redirect()->to("/");
            }
        }

        $data['controller']= "connexion";
        $data['erreurs'] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['identifiant'] = (isset($_POST['identifiant'])) ? $_POST['identifiant'] : "";
        $data['motDePasse'] = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : "";

        return view('page_accueil/connexion.php',$data);
    }

    public function inscription()
    {
        $post=$this->request->getPost();
        $issues=[];

        if(!empty($post))
        {
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->inscription($user,$post['confirmezMotDePasse']); 

            if(empty($issues)) 
            {
                return redirect()->to("/");
            }
        }

        $data['controller']= "inscription";
        $data['erreurs'] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['pseudo'] = (isset($_POST['pseudo'])) ? $_POST['pseudo'] : "";
        $data['nom'] = (isset($_POST['nom'])) ? $_POST['nom'] : "";
        $data['prenom'] = (isset($_POST['prenom'])) ? $_POST['prenom'] : "";
        $data['email'] = (isset($_POST['email'])) ? $_POST['email'] : "";
        $data['motDePasse'] = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : "";
        $data['confirmezMotDePasse'] = (isset($_POST['confirmezMotDePasse'])) ? $_POST['confirmezMotDePasse'] : "";

        return view('page_accueil/inscription.php',$data);
    }

    public function produit($idProduit = null)
    {
        if($idProduit == null)
        {
            return view('errors/html/error_404.php', array('message' => "Pas de produit spécifié"));
        }
       
        $prodModel = model("\App\Models\ProduitDetail");
        $result = $prodModel->find($idProduit);
        
        if($result == null)
        {
            return view('errors/html/error_404.php', array('message' => "Ce produit n'existe pas"));
        }
        else
        {
            $data['controller'] = "produit";

            $data['prod'] = $result;
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

    public function viderPanierClient()
    {
        session() -> get("numero");
        $ProduitPanierModel = model("\App\Models\ProduitPanierModel");
        //$ProduitPanierModel -> viderPanierClient
    }

    private const NBPRODSPAGECATALOGUE = 10;
    #FIXME: comportement href différent entre $page=null oe $page !=null    

    public function catalogue($page=null)
    {
        $get=$this->request->getGet();
        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $data['controller']="Catalogue";
        
        $data['nombreMaxPages']=(sizeof($data['prods']) % self::NBPRODSPAGECATALOGUE)+1;
        if(is_null($page) || $page==0)
        {
            $data['minProd']=0;
            $data['maxProd']=self::NBPRODSPAGECATALOGUE;
            $data['page']=0;
        }
        else
        {
            if($data['nombreMaxPages']>=$page)
            {
                $data['page']=$page;

                $data['minProd']=self::NBPRODSPAGECATALOGUE*$page;
                $data['maxProd']=self::NBPRODSPAGECATALOGUE*($page+1);
                
            }
            else return view('errors/html/error_404.php', array('message' => "Page trop haute: pas assez de produit"));
        }
        return view("catalogue.php",$data);
    }
    public function import()
    {

        $data['controller']= "import";
        $row = 0;
        $fichier = fopen("ressources/data.csv", "r");
        $size = fstat($fichier)["size"];
        while (($dataCSV = fgetcsv($fichier, $size, ';')) !== FALSE) {
            $num = count($dataCSV);
            for ($c=0; $c < $num; $c++) {
                $retour[$row][$c] = $dataCSV[$c];
            }
            $row++;
        }
        fclose($fichier);
        $new_table = array();
        for ($i=0; $i < count($retour); $i++) 
        { 
            //on itère sur chaque ligne
            if (count($retour[0]) == count($retour[$i]))
            {
                for ($j=0; $j < count($retour[0]); $j++) 
                {
                    $new_table[$i][$retour[0][$j]] = $retour[$i][$j];
                }
            }
        }
        $result = array_slice($new_table,1);
        print_r($result);
        $importModel = model("\App\Models\ImportCSV");
        $importModel->CSVimport($result);
        return view('page_accueil/import.php', $data);
    }
}
