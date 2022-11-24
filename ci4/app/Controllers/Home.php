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
    
    private const NBPRODSPAGECATALOGUE = 18;
    #FIXME: comportement href différent entre $page=null oe $page !=null    
    public function catalogue($page=null)
    {
        $filters=$this->request->getGet();
        $modelProduitCatalogue=model("\App\Models\ProduitCatalogue");
        $data['cardProduit']=service("cardProduit");
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $data['controller']="Catalogue";
        $data['prods'] = [];
        $data['max_price'] = $modelProduitCatalogue->selectMax('prixttc')->find()[0]->prixttc;
        $data['min_price'] = $modelProduitCatalogue->selectMin('prixttc')->find()[0]->prixttc;

        if(empty($filters)){
            $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
        }
        else{
            foreach(array_keys($filters) as $key){
                $data['prods'] = array_merge($data['prods'],model("\App\Models\ProduitCatalogue")->where("categorie",$key)->findAll());
            }
        }

        $data['nombreMaxPages']=intdiv(sizeof($data['prods']),self::NBPRODSPAGECATALOGUE)
            + ((sizeof($data['prods']) % self::NBPRODSPAGECATALOGUE==0)?0:1);
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

    public function espaceClient()
    {
        $data['controller'] = "EspaceClient";
        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelClient = model("\App\Models\Client");
        $post=$this->request->getPost();
        $client = $modelClient->getClientById(session()->get("numero"));
        $issues = [];

        //Valeurs par défaut
        $data['motDePasse'] = "motDePassemotDePasse";
        $data['confirmezMotDePasse'] = "";
        $data['nouveauMotDePasse'] = "";

        //On cache par défaut les champs supplémentaires pour modifier le mdp
        $data['classCacheDiv'] = "cacheModifMdp";
        $data['disableInput'] = "disabled";
        $data['requireInput'] = "";

        if (!empty($post))
        {
            //Ce champs ne semble pas être défini si l'utilisateur n'y touche pas, on en informe le service
            if (!isset($post['motDePasse']))
            {
                $post['motDePasse'] = "motDePassemotDePasse";
            }

            //Si ces deux champs ne sont pas remplis, cela veut dire que l'utilisateur n'a pas cherché à modifier le mdp
            if (empty($post['confirmezMotDePasse']) && empty($post['nouveauMotDePasse']))
            {
                //On remplit ces variables pour informer le service que nous n'avons pas besoin d'erreurs sur ces champs
                $post['confirmezMotDePasse'] = "";
                $post['nouveauMotDePasse'] = "";
            }
            else
            {
                //Si l'utilisateur a cherché à modifier le mdp, alors on révèle les champs
                $data['classCacheDiv'] = "";
                $data['disableInput'] = "";
                $data['requireInput'] = "required";
            }

            $auth = service('authentification');
            $user=$client;
            $user->fill($post);
            $issues=$auth->modifEspaceClient($user, $post['confirmezMotDePasse'], $post['nouveauMotDePasse']); 
            
            if (!empty($issues))
            {
                //En cas d'erreur(s), on pré-remplit les champs avec les données déjà renseignées
                $data['motDePasse'] = $post['motDePasse'];
                $data['confirmezMotDePasse'] = $post['confirmezMotDePasse'];
                $data['nouveauMotDePasse'] = $post['nouveauMotDePasse'];
            }
            else
            {
                return redirect()->to("/espaceClient");
            }
        }
        
        //Pré-remplit les champs avec les données de la base
        $data['pseudo'] = $client->identifiant;
        $data['prenom'] = $client->prenom;
        $data['nom'] = $client->nom;
        $data['email'] = $client->email;
        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numero"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numero"));
        $data['erreurs'] = $issues;

        return view('/page_accueil/espaceClient',$data);
    }

    public function lstCommandesVendeur()
    {
        $data['controller']= "lstCommandesVendeur";
        $data['commandesVend']=model("\App\Models\LstCommandesVendeur")->findAll();
        return view('page_accueil/lstCommandesVendeur.php', $data);
    }

    public function paiement() 
    {
        $post=$this->request->getPost();
        $issues=[];
        $data['controller']='paiement';

        if(!empty($post))
        {
            $paiement = service('authentification');
            $issues=$paiement->paiement($post);

            if(empty($issues))
            {
                return redirect()->to("/");
            }
        }
        $data['erreurs'] = $issues;
        $data['nomCB'] = (isset($_POST['nomCB'])) ? $_POST['nomCB'] : "";
        $data['numCB'] = (isset($_POST['numCB'])) ? $_POST['numCB'] : "";
        $data['dateExpiration'] = (isset($_POST['dateExpiration'])) ? $_POST['dateExpiration'] : "";
        $data['CVC'] = (isset($_POST['CVC'])) ? $_POST['CVC'] : "";

        return view('page_accueil/paiement.php', $data);
    }
    
    //Tant que commande n'est pas là
    public function commandeTest(){
        
        echo "oui";
    }
}
