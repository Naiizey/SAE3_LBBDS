<?php

namespace App\Controllers;

class Home extends BaseController 
{

    public function __construct()
    {
        //permer d'éviter le bug de redirection.
        session();
        $this->feedback=service("feedback");
    }

    public function index()
    {

        if(session()->has("just_connectee") && session()->get("just_connectee")==true){
            
            session()->set("just_connectee",False);
            $data['validation'] = $this->feedback->afficheValidation("Vous êtes connecté !");
            
        }

        $data['controller']= "index";

        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
 
        return view('page_accueil/index.php',$data);
    }

    public function connexion($context= null)
    {
        $post=$this->request->getPost();
        $issues=[];
        
        
        if(!empty($post))
        {
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->connexion($user); 

            if(empty($issues) && is_null($context)) 
            {
                return redirect()->to("/");
            }
            else if(empty($issues) && !is_null($context))
            {
                return redirect()->to("/commandes");
            }
        }

        if(!is_null($context) && $context==401)
        {
            $issues['redirection']="Vous devez vous connectez pour valider votre commande";
            $data['estRedirection']=True;
            $data['controller']= "compte_redirection";
        }
        else
        {
            $data['controller']= "connexion";
        }
       
        $data['erreurs'] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['identifiant'] = (isset($_POST['identifiant'])) ? $_POST['identifiant'] : "";
        $data['motDePasse'] = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : "";

        return view('page_accueil/connexion.php',$data);
    }

    public function inscription($context=null)
    {
        $post=$this->request->getPost();
        $issues=[];

       

        if(!empty($post))
        {
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->inscription($user,$post['confirmezMotDePasse']); 

            if(empty($issues) && is_null($context)) 
            {
                return redirect()->to("/");
            }
            else if(empty($issues) && !is_null($context))
            {
                return redirect()->to("/commandes");
            }
        }

        if(!is_null($context) && $context==401){
            $issues['redirection']="Vous devez avoir un compte pour valider votre commande";
            $data['estRedirection']=True;
            
            $data['controller']= "compte_redirection";
        }
        else
        {
            $data['controller']= "connexion";
        }
        
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

    
    #FIXME: comportement href différent entre $page=null oe $page !=null    

    public function catalogue($page=null)
    {
        $filters=$this->request->getGet();
        $data['cardProduit']=service("cardProduit");
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $data['controller']="Catalogue";

        $data=array_merge(
            $data,
            (new \App\Controllers\Produits())->getAllProduitSelonPage($page,$filters)
        );
        
        
       
        return view("catalogue.php",$data);
    }

    public function lstCommandesVendeur()
    {
        $data['controller']= "lstCommandesVendeur";
        $data['commandesVend']=model("\App\Models\LstCommandesVendeur")->findAll();
        return view('page_accueil/lstCommandesVendeur.php', $data);
    }
    
    //Tant que commande n'est pas là
    public function commandeTest(){
        
        echo "oui";
    }
}
