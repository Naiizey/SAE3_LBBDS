<?php namespace App\Controllers\Vendeur;

use CodeIgniter\CodeIgniter;
use CodeIgniter\Cookie\Cookie;
use Config\Services;
use App\Controllers\BaseController;
use Exception;

class Quidi extends BaseController
{
    private $feedback;

    public function __construct()
    {
        helper('cookie');
        
        if (session()->has("numeroVendeur")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numeroVendeur"));
        } else if (has_cookie("token_panier")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token_panier"));
        } else {
            $GLOBALS["quant"] = 0;
        }

        $this->feedback=service("feedback");
        if (session()->has("just_connectee") && session()->get("just_connectee")==true) {
            session()->set("just_connectee", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Vous êtes connecté !");
        }
    }
    public function index()
    {
        return view('vendeur/quidi');
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

    /**
     * @method getProduitPanierVendeur
     * Récupére tout les produits du panier:
     *  -Vérification pour le feedback
     *  -Vérification et application des choix sur l'alerte fusion
     *  -Récupération contenu du panier
     *  Si panier rempli:
     *         -Récupération code réduction
     *
     * @return void
     */
    public function getProduitPanierVendeur()
    {
        $data['model'] = model("\App\Models\ProduitCatalogue");
        $data['cardProduit'] = service("cardProduit");
        
        if(session()->has("just_vide") && session()->get("just_vide") == true) {
            $this->feedback=service("feedback");
            session()->set("just_vide", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Panier vidé");
        }
        $get=$this->request->getGet();

        $data["controller"] = "Panier";
        $data['code'] = "";
        $data['classCacheDiv'] = "cacheNouveauPrix";
        $issues = [];
        $retours = [];
        $modelCodeReduc = model("\App\Models\CodeReduction");
        $modelReducPanier = model("\App\Models\ReducPanier");

        //Récupération des produits du panier
        if(session()->has("numeroVendeur"))
        {
            $modelProduitPanier = model("\App\Models\ProduitPanierCompteModel");
            $data['produits'] = $modelProduitPanier->getPanier(session()->get("numeroVendeur"));
        }
        else
        {
            $data['produits'] = array();
        }
        
        //Si on a un panier qui est rempli (en étant visiteur ou client)
        if (isset($modelProduitPanier) && !empty($data['produits']))
        {
            //On peut voir le numéro du panier dans l'id d'un produit panier sous cette forme : id_produit£num_panier (ex: 17£1)
            $numPanier = $data['produits'][0]->id;
            $numPanier = explode('£', $numPanier);
            $numPanier = $numPanier[1];
            
            $panier = $modelReducPanier->getReducByPanier($numPanier);

            //S'il y a déjà un code associé à ce panier
            if (!empty($panier))
            {
                //Alors on le récupère
                $codeReduc = $modelCodeReduc->getCodeReducById($panier[0]->id_reduction)[0];

                //On informe la vue qu'il faut afficher le code
                $data['code'] = $codeReduc->code_reduction;
            }
            
            //On regarde s'il y a un code donné dans le post
            $post=$this->request->getPost();
    
            if (!empty($post))
            {
                //On informe la vue qu'il faut afficher le code
                $data['code'] = $post['code'];

                $codeReduc = $modelCodeReduc->getCodeReducByCode($post['code']);

                if (empty($codeReduc)) {
                    $issues[0] = "Ce code n'existe pas";
                } else {
                    //Le code étant unique dans la base on choisi le premier et seul résultat du findAll
                    $codeReduc = $codeReduc[0];
                    $date_ajd = date("Y-m-d H:i:s");
                    $date_debut = $codeReduc->date_debut . " " . $codeReduc->heure_debut;
                    $date_fin = $codeReduc->date_fin . " " . $codeReduc->heure_fin;

                    if ($date_debut > $date_ajd && $date_ajd < $date_fin)
                    {
                        $issues[1] = "Ce code est expiré";
                    }
                    else
                    {
                        //S'il y avait déjà un code associé alors on le supprime
                        if (!empty($panier))
                        {
                            $modelReducPanier->dissocierCodeAPanier($numPanier);
                        }

                        //Le code est valide on va le lier au panier avec la base de donnée afin qu'il soit tout le temps effectif
                        $modelReducPanier->associerCodeAPanier($numPanier, $codeReduc->id_reduction);
                    }
                }
            }
            

            if (isset($codeReduc) && empty($issues))
            {
                //Tout est bon, il reste a savoir si le code réduit le prix avec un montant ou un pourcentage de réduction
                if ($codeReduc->montant_reduction != 0)
                {
                    $retours[0] = "Vous économisez <span>" . $codeReduc->montant_reduction . "€</span>";
                }
                else
                {
                    $retours[1] = "Vous économisez <span>" . $codeReduc->pourcentage_reduction . "%</span>";
                }
                
                //On affiche le nouveau prix
                $data['classCacheDiv'] = "decouvreNouveauPrix";
            }
        }
        //Fusion automatique du panier
        elseif (has_cookie("token_panier") && session()->has("numeroVendeur"))
        {
            
            model("\App\Models\ProduitPanierCompteModel")->fusionPanier(session()->get("numeroVendeur"),get_cookie("token_panier"));
            delete_cookie("token_panier");
            $data["ecraserOuFusionner"]=true;
            $data["produits"]=$modelProduitPanier->getPanier(session()->get("numeroVendeur"));
        }
        $data["erreurs"] = $issues;
        $data['retours'] = $retours;

        return view('vendeur/quidi.php', $data);
    }

    public function viderQuidi() {
        if(session()->has("numeroVendeur"))
        {
            $panierModel = model("\App\Models\ProduitPanierCompteModel");
            $panierModel->viderQuidi(session()->get("numeroVendeur"));
        }
        else throw new \Exception("Le panier n'existe pas !");
        
        
        session()->set("just_vide", true);
        return redirect()->to("panier")->withCookies();;
    }

    public function ajouterQuidi($idProd=null,$quantite=null) {
        $data["controller"] = "Quidi";
        
        if($quantite==null && isset($this->request)){
            if($this->request->getPost("quantite")==="10+")
            {
                $quantite=$this->request->getPost("quantitePlus");
            }
            else
            {
                $quantite=$this->request->getPost("quantite");
            }
           
        }
        
        if(!is_null($idProd) && !is_null($quantite))
        {
        
            if(session()->has("numeroVendeur"))
            {
                            
                $panierModel = model("\App\Models\ProduitPanierCompteModel");
                $panierModel->ajouterProduit($idProd,$quantite,session()->get("numeroVendeur"),$quantite,true);
            }
            else
            {   
                $token=$this->creerPanier();
                $panierModel = model("\App\Models\ProduitPanierVisiteurModel");
                $panierModel->ajouterProduit($idProd,$quantite,$token,$quantite,true);
                //return $token; 
            }
            
                
            
        }

        if(isset($this->request)){
            session()->set("just_ajoute", true);
            return redirect()->to(session()->get("_ci_previous_url"));
        }
       
        
    
    }

    public function supprimerProduitQuidi($idProd = null){
        if(!is_null($idProd))
        {
            if(session()->has("numeroVendeur"))
            {
                $panierModel = model("\App\Models\ProduitPanierCompteModel");
                $panierModel->deleteFromPanier($idProd,session()->get("numeroVendeur"));
            }
            else if(has_cookie("token_panier"))
            {
                $panierModel = model("\App\Models\ProduitPanierVisiteurModel");
                $panierModel->deleteFromPanier($idProd,get_cookie("token_panier"));
                $this->updatePanier(get_cookie("token_panier"));
            }
            else throw new \Exception("Le panier n'existe pas !");
        }
        if(isset($this->request)){
            return redirect()->to(session()->get("_ci_previous_url"));
        }
    }

    public function modifierProduitPanier($id = null, $newQuantite = null){

        
            if (session()->has("numeroVendeur"))
            {
                try {
                    model("\App\Models\ProduitPanierCompteModel")->changerQuantite($id,session()->get("numeroVendeur"),$newQuantite);
                    $result = array("prodChanged" => $id,"forVendeurId" => session()->get("numeroVendeur"));
                    $code=200;
                } catch (\Exception $e){
                    $result = array("error" => $e);
                    $code=500;
                }
            } elseif (has_cookie("token_panier"))
            {
                try {
                    model("\App\Models\ProduitPanierVisiteurModel")->changerQuantite($id, get_cookie("token_panier"),$newQuantite);
                    $result = array("prodChanged" => $id,"forVendeurId" =>  get_cookie("token_panier"));
                    $code=200;
                    $this->updatePanier(get_cookie("token_panier"));
                
                } catch (\ErrorException $e) {
                    //echo $e;
                    $result = array("error" => $e->getMessage());
                    $code=500;
                }
            } else throw new \Exception("Le panier n'existe pas !");
            
            if(!isset($this->request)) {
                return $result;
            } elseif($this->request->getMethod()==="put") {
                return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
                ->setStatusCode($code)->setJSON($result);
            }
            /*
            else if(isset($this->request) && $this->request->getMethod()==="get")
            {
                return redirect()->to(session()->get("_ci_previous_url"));
            }
            */
    }

    public function sendCors($idProd = null, $newQuantite = null){
        
        if(isset($this->request) && $this->request->getMethod()==="options"){
            return $this->response->setHeader('Access-Control-Allow-Methods','PUT, OPTIONS')->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type')->setHeader('Access-Control-Allow-Origin', '*')
            ->setStatusCode(200);
        }
    }

    public function creerPanier(){
        $token = bin2hex(\openssl_random_pseudo_bytes(16));
        $expiration=strtotime('+24 hours');
        $model=model("\App\Models\ProduitPanierVisiteurModel");
        $token=$model->createPanierVisiteur($token,$expiration);


        setcookie('token_panier',$token,array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
        return $token;
    }

    public function updatePanier($token){
        
        $expiration=strtotime('+24 hours');
        $model=model("\App\Models\ProduitPanierVisiteurModel");
        $token=$model->updatePanierVisiteur($token,$expiration);


        setcookie('token_panier',$token,array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
        return $token;
    }
}