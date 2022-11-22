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

        if(session()->has("just_connectee") && session()->get("just_connectee")==true){
            
            session()->set("just_connectee",False);
            $data['validation'] = $this->afficheValidation("Vous êtes connecté !");
            
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

    private const NBPRODSPAGECATALOGUE = 18;
    #FIXME: comportement href différent entre $page=null oe $page !=null    

    public function catalogue($page=null)
    {
        $get=$this->request->getGet();
        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $data['controller']="Catalogue";
        
        $data['nombreMaxPages']=intdiv(sizeof($data['prods']),self::NBPRODSPAGECATALOGUE)
            + ((sizeof($data['prods']) % self::NBPRODSPAGECATALOGUE==0)?0:1) ;
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

                $data['minProd']=self::NBPRODSPAGECATALOGUE*($page-1);
                $data['maxProd']=self::NBPRODSPAGECATALOGUE*$page;
                
            }
            else return view('errors/html/error_404.php', array('message' => "Page trop haute: pas assez de produit"));
        }
       
        return view("catalogue.php",$data);
    }

    public function lstCommandes()
    {
        $data['controller']= "lstCommandes";
        return view('page_accueil/lstCommandes.php', $data);
    }
    
    //Tant que commande n'est pas là
    public function commandeTest(){
        
        echo "oui";
    }

    public function afficheValidation(string $message){
        ob_start() ?>
        <div class="alerte-validation valide">
            <p>
            <span class="logo-validation">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="" class="bi bi-check-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
            </svg>
            </span>
            <span>
                <?= $message ?>
            </span>
            </p>
        </div>

        <?php return ob_get_clean();
    }

    public function afficheInvalidation(string $message){
        ob_start() ?>
        <div class="alerte-validation invalide">
            <p>
            <span class="logo-validation">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
            </svg>
            </span>
            <span>
                <?= $message ?> 
            </span>
            </p>
        </div>

        <?php return ob_get_clean();
    }
}
