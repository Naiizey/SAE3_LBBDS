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

            if(empty($issues) && !session()->has("referer_redirection")) 
            {
                return redirect()->to("/");
            }
            else if(empty($issues) && session()->has("referer_redirection"))
            {
                if(parse_url(session()->get("referer_redirection")) === "panier")
                {
                    return redirect()->to("/commandes");
                }
                else
                {
                    return redirect()->to(session()->get("referer_redirection"));
                }
            }
        }

        if(session()->has("referer_redirection"))
        {
            
            $data['linkRedirection']=session()->get("referer_redirection");
            if(parse_url($data['linkRedirection']) === "panier"){
                $issues['redirection']="Vous devez vous connectez pour valider votre commande";
                $data['controller']= "compte_redirection";
            }
            else{
                $issues['redirection']="Vous devez vous connectez pour y accéder";
                $data['controller']= "connexion";
            }
            
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

            if(empty($issues) && !session()->has("referer_redirection")) 
            {
                return redirect()->to("/");
            }
            else if(empty($issues) && session()->has("referer_redirection"))
            {
                if(parse_url(session()->get("referer_redirection")) === "panier")
                {
                    return redirect()->to("/commandes");
                }
                else
                {
                    return redirect()->to(session()->get("referer_redirection"));
                }
            }
        }

        if(session()->has("referer_redirection")){
            $data['linkRedirection']=session()->get("referer_redirection");
            if(parse_url($data['linkRedirection']) === "panier"){
                $issues['redirection']="Vous devez vous connectez pour valider votre commande";
                $data['controller']= "compte_redirection";
            }
            else{
                $issues['redirection']="Vous devez vous connectez pour accéder à cette espace";
                $data['controller']= "inscription";
            }
        }
        else
        {
            $data['controller']= "inscription";
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

        if(isset($filters["prix_min"]) && isset($filters["prix_max"]))
        {
            $price = [];
            $price = ["prix_min"=>$filters["prix_min"], "prix_max"=>$filters["prix_max"]];

            array_pop($filters);
            array_pop($filters);

            $priceQuery = $modelProduitCatalogue->where('prixttc >=',$price["prix_min"])->where('prixttc <=',$price["prix_max"]);

            if(empty($filters)){
                $data['prods'] = $priceQuery->orderBy('prixttc')->findAll();
            }
            else{
                foreach(array_keys($filters) as $key){
                    $data['prods'] = array_merge($data['prods'],$modelProduitCatalogue->
                    where('categorie',$key)->where('prixttc >=',$price["prix_min"])->
                    where('prixttc <=',$price["prix_max"])->findAll());
                }
            }
        }

        
        else{
            if(empty($filters)){
                $data['prods']=$modelProduitCatalogue->findAll();
            }
            else{
                foreach(array_keys($filters) as $key){
                    $data['prods'] = array_merge($data['prods'],$modelProduitCatalogue->where("categorie",$key)->findAll());
                }
            }
        }

        if(empty($data['prods'])){
            return view('errors/html/error_404.php', array('message' => "Aucun produit disponible avec les critères sélectionnés"));
        }
        
        if(isset($filters)){
            $filtersInline = "";
            foreach($filters as $key => $value){
                $filtersInline .= "&".$key."=".$value;
            }
            $filtersInline = substr($filtersInline,0);
            $filtersInline = "?".$filtersInline;
        }

        if(isset($price)){
            $priceInline = "";
            foreach($price as $key => $value){
                $priceInline .= "&".$key."=".$value;
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
                if(isset($price) && isset($filters)){
                    $data['page']=$page . "/" . $filtersInline . $priceInline;
                }
                else if(isset($filetrs)){
                    $data['page']=$page . "/" . $filtersInline;
                }
                else if(isset($price)){
                    $data['page']=$page . "/" . $priceInline;
                }
                else{
                    $data['page']=$page;
                }

                $data['minProd']=self::NBPRODSPAGECATALOGUE*($page-1);
                $data['maxProd']=self::NBPRODSPAGECATALOGUE*$page;
                
            }
            else return view('errors/html/error_404.php', array('message' => "Page trop haute: pas assez de produit"));
        }
               
       
        return view("catalogue.php",$data);
    }


    public function infoLivraison(){
        
        $data['controller']='infoLivraison';
        

        return view('formAdresse.php',$data);


    }

    public function lstCommandes()
    {
        $data['controller']= "lstCommandesCli";
        $data['commandesCli']=model("\App\Models\lstCommandesCli")->getCompteCommandes();
        return view('page_accueil/lstCommandesCli.php', $data);
    }

    public function lstCommandesVendeur()
    {
        $data['controller']= "lstCommandesVendeur";
        $data['commandesVend']=model("\App\Models\LstCommandesVendeur")->findAll();
        return view('page_accueil/lstCommandesVendeur.php', $data);
    }

    public function paiement() {
        $post=$this->request->getPost();
        $issues=[];
        $data['controller']='paiement';
        //appel au service de paiement
        if(!empty($post))
        {
            $paiement = service('card');
            $issues=$paiement->verifcard($post);
            if(empty($issues))
            {
                return redirect()->to("/");
            }
        }
        $data['nomCB'] = (isset($_POST['nomCB'])) ? $_POST['nomCB'] : "";
        $data['numCB'] = (isset($_POST['numCB'])) ? $_POST['numCB'] : "";
        $data['DateExpiration'] = (isset($_POST['DateExpiration'])) ? $_POST['DateExpiration'] : "";
        $data['CCV'] = (isset($_POST['CCV'])) ? $_POST['CCV'] : "";
        return view('page_accueil/paiement.php', $data);
    }
    
    //Tant que commande n'est pas là
    public function commandeTest(){
        
        echo "oui";
    }
}
