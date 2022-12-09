<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use Exception;



class Home extends BaseController
{
    public function __construct()
    {
        //permer d'éviter le bug de redirection.
        session();
        //Affichage de la quantité panier
        helper('cookie');
        if (session()->has("numero")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
        } elseif (has_cookie("token_panier")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token_panier"));
        } else {
            $GLOBALS["quant"] = 0;
        }
        //au cas où __ci_previous_url ne marcherait plus...: session()->set("previous_url",current_url());
        $this->feedback=service("feedback");
        if (session()->has("just_connectee") && session()->get("just_connectee")==true) {
            session()->set("just_connectee", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Vous êtes connecté !");
        }
    }

    public function index()
    {
        $data["controller"]= "Accueil";
        if(session()->has("just_ajoute") && session()->get("just_ajoute") == true) {
            $this->feedback=service("feedback");
            session()->set("just_ajoute", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Article ajouté");
        }
        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();
        if (session()->has("numero")) {
            $data['quant'] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
        } elseif (has_cookie("token_panier")) {
            $data['quant'] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token"));
        } else {
            $data['quant'] = 0;
        }
        return view('page_accueil/index.php', $data);
    }

    public function connexion()
    {
        $post=$this->request->getPost();
        $issues=[];

        if (!empty($post)) {
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->connexion($user);
            if(empty($issues)){
                if (!session()->has("referer_redirection")) {
                    return redirect()->to("/");
                
                }else {
                 
                    $redirection=session()->get("referer_redirection");
                    session()->remove("referer_redirection");
                    return redirect()->to($redirection);
                }
            }
           
        }

        if (session()->has("referer_redirection")) {
            $data['linkRedirection']=session()->get("referer_redirection");
           
             
            $issues['redirection']="Vous devez vous connectez pour y accéder";
            $data["controller"]= "Connexion";
            
        } else {
            $data["controller"]= "Connexion";
        }

        $data['erreurs'] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['identifiant'] = (isset($_POST['identifiant'])) ? $_POST['identifiant'] : "";
        $data['motDePasse'] = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : "";

        return view('page_accueil/connexion.php', $data);
    }

    public function inscription()
    {
        $post=$this->request->getPost();
        $issues=[];

        if (!empty($post)) {
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);


            $issues=$auth->inscription($user, $post['confirmezMotDePasse']);

            if(empty($issues)){
                if (!session()->has("referer_redirection")) {
                    return redirect()->to("/");
                
                }else {
                    
                    $redirection=session()->get("referer_redirection");
                    session()->remove("referer_redirection");
                    return redirect()->to($redirection);
                }
            }
           
        }
        

        if (session()->has("referer_redirection")) {
            $data['linkRedirection']=session()->get("referer_redirection");
            if (parse_url($data['linkRedirection']) === "livraison") {
                $issues['redirection']="Vous devez vous connectez pour valider votre commande";
                $data["controller"]= "Compte Redirection";
            } else {
                $issues['redirection']="Vous devez vous connectez pour accéder à cette espace";
                $data["controller"]= "Inscription";
            }
        } else {
            $data["controller"]= "Inscription";
        }

        $data['erreurs'] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['pseudo'] = (isset($_POST['pseudo'])) ? $_POST['pseudo'] : "";
        $data['nom'] = (isset($_POST['nom'])) ? $_POST['nom'] : "";
        $data['prenom'] = (isset($_POST['prenom'])) ? $_POST['prenom'] : "";
        $data['email'] = (isset($_POST['email'])) ? $_POST['email'] : "";
        $data['motDePasse'] = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : "";
        $data['confirmezMotDePasse'] = (isset($_POST['confirmezMotDePasse'])) ? $_POST['confirmezMotDePasse'] : "";

        return view('page_accueil/inscription.php', $data);
    }

    public function produit($idProduit = null)
    {
        $data['model'] = model("\App\Models\ProduitCatalogue");
        $data['cardProduit']=service("cardProduit");
        
        // Gestion du feedback
        if(session()->has("just_ajoute") && session()->get("just_ajoute") == true) {
            $this->feedback=service("feedback");
            session()->set("just_ajoute", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Article ajouté");
        }

        //Assertion
        if ($idProduit == null) {
            return view('errors/html/error_404.php', array('message' => "Pas de produit spécifié"));
        }

        //Get quantité du panier
        if (session()->has('numero')) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierCompteModel")->getQuantiteProduitByIdProd($idProduit, session()->get('numero'));
        } elseif (has_cookie('token_panier')) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierVisiteurModel")->getQuantiteProduitByIdProd($idProduit, get_cookie('token_panier'));
        }

        //Get produituk
        $prodModel = model("\App\Models\ProduitDetail");
        $result = $prodModel->find($idProduit);

        //Affichage selon si produit trouvé ou non
        if ($result == null) {
            return view('errors/html/error_404.php', array('message' => "Ce produit n'existe pas"));
        } else {
            $data["controller"] = "Produit";

            $data['prod'] = $result;
            return view('page_accueil/produit.php', $data);
        }
    }


    private const NBPRODSPAGECATALOGUE = 20;
    #FIXME: comportement href différent entre $page=null oe $page !=null
    
    public function catalogue($page=1)
    {
        if(session()->has("just_ajoute") && session()->get("just_ajoute") == true) {
            $this->feedback=service("feedback");
            session()->set("just_ajoute", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Article ajouté");
        }
        $filters=$this->request->getGet();
        $modelProduitCatalogue=model("\App\Models\ProduitCatalogue");
        $data['cardProduit']=service("cardProduit");
        $data['categories']=model("\App\Models\CategorieModel")->findAll();
        $data["controller"] = "Catalogue";
        $data['prods'] = [];
        $data['vide'] = false;
        $data['max_price'] = $modelProduitCatalogue->selectMax('prixttc')->find()[0]->prixttc;
        //dd($data['max_price']);
        $data['min_price'] = $modelProduitCatalogue->selectMin('prixttc')->find()[0]->prixttc;
        if(isset($filters["prix_min"]) && isset($filters["prix_max"])){
            $price = ["prix_min"=>$filters["prix_min"], "prix_max"=>$filters["prix_max"]];
        }
        
        

        $result=(new \App\Controllers\Produits())->getAllProduitSelonPage($page,self::NBPRODSPAGECATALOGUE,$filters);
        $data['prods']=$result["resultat"];
        $data['estDernier']=$result["estDernier"];
        
        

        if (isset($filters)) {
            $filtersInline = "";
            foreach ($filters as $key => $value) {
                $filtersInline .= "&".$key."=".$value;
            }
            $filtersInline = substr($filtersInline, 0);
            $filtersInline = "?".$filtersInline;
            $data['filters'] = $filtersInline;
        }

        if (isset($price)) {
            $priceInline = "";
            foreach ($price as $key => $value) {
                $priceInline .= "&".$key."=".$value;
            }
            $data['filters'] .= $priceInline;
        }

        if ($data['prods']) {
            $data['vide'] = true;
        }

        return view("catalogue.php", $data);
    }
    

 

    public function espaceClient($role = null, $numClient = null)
    {
        $data["controller"] = "Espace Client";
        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelClient = model("\App\Models\Client");
        $post=$this->request->getPost();

        $data['numClient'] = $numClient;
        $data['role'] = "";
        if ($role == "admin" && $numClient != null) {
            $data['role'] = "admin";
        } else { 
            $data['role'] = "client";
            $numClient = session()->get("numero");
        }

        $issues = [];
        $client = $modelClient->getClientById($numClient);
        $clientBase = $modelClient->getClientById($numClient);
        $data['prenomBase'] = $clientBase->prenom;

        //Valeurs par défaut
        $data['motDePasse'] = "motDePassemotDePasse";
        $data['confirmezMotDePasse'] = "";
        $data['nouveauMotDePasse'] = "";

        //On cache par défaut les champs supplémentaires pour modifier le mdp
        $data['classCacheDiv'] = "cacheModifMdp";
        $data['disableInput'] = "disabled";
        $data['requireInput'] = "";

        if (!empty($post)) {
            helper('cookie');
            if (session()->has("numero")) {
                $data['quant'] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
            } elseif (has_cookie("token_panier")) {
                $data['quant'] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token"));
            } else {
                $data['quant'] = 0;
            }

            //Ce champs ne semble pas être défini si l'utilisateur n'y touche pas, on en informe le service
            if (!isset($post['motDePasse'])) {
                $post['motDePasse'] = "motDePassemotDePasse";
            }

            //Si ces deux champs ne sont pas remplis, cela veut dire que l'utilisateur n'a pas cherché à modifier le mdp
            if (empty($post['confirmezMotDePasse']) && empty($post['nouveauMotDePasse'])) {
                //On remplit ces variables pour informer le service que nous n'avons pas besoin d'erreurs sur ces champs
                $post['confirmezMotDePasse'] = "";
                $post['nouveauMotDePasse'] = "";
            } else {
                //Si l'utilisateur a cherché à modifier le mdp, alors on révèle les champs
                $data['classCacheDiv'] = "";
                $data['disableInput'] = "";
                $data['requireInput'] = "required";
            }

            $auth = service('authentification');
            $user=$client;
            $user->fill($post);
            $issues=$auth->modifEspaceClient($user, $post['confirmezMotDePasse'], $post['nouveauMotDePasse']);

            if (!empty($issues)) {
                //En cas d'erreur(s), on pré-remplit les champs avec les données déjà renseignées
                $data['motDePasse'] = $post['motDePasse'];
                $data['confirmezMotDePasse'] = $post['confirmezMotDePasse'];
                $data['nouveauMotDePasse'] = $post['nouveauMotDePasse'];
            } else {
                if ($role == "admin") {
                    return redirect()->to("/espaceClient/admin/" . $numClient);
                } else {
                    return redirect()->to("/espaceClient");
                }
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

        return view('/page_accueil/espaceClient.php', $data);
    }

    public function infoLivraison()
    {
        //Assetion Début
        if (!session()->has("numero")) {
            throw new Exception("Erreur, vous devez être connecté ", 401);
        }


        $model=model("\App\Models\AdresseLivraison");

        $client=model("\App\Models\Client")->getClientById(session()->get("numero"));
      
        $data["controller"] = "Livraisons";
        $post=$this->request->getPost();
        $adresse = new \App\Entities\Adresse();

        if (isset($post["utilise_nom_profil"])) {
            $data["profil_utilisee"]=true;
            unset($post["utilise_nom_profil"]);
        } else {
            $data["profil_utilisee"]=false;
        }

        $this->validator = Services::validation();
        $this->validator->setRules($model->rules);

        if (!empty($post)) {
            $adresse->fill($post);
            if ($adresse->checkAttribute($this->validator)) {
               
                $id_a=$model->enregAdresse($adresse);
                /*
                $expiration=strtotime('+24 hours');
                setcookie('id_adresse_livraison', $id_a, array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
                */
                session()->set("adresse_livraison",$id_a);
                return redirect()->to("/paiement");
            }
        }else if(session()->has("adresse_livraison")){
            $adresse=model("\App\Models\AdresseLivraison")->find(session()->get("adresse_livraison"));
            $data["dejaRempli"] = "Adresse livraison validée et réutilisée";
            
        }

        $data['adresse']=$adresse;
        $data['client']=$client;
        $data['errors']=$this->validator;


        
        return view('templLivraison.php', $data);
    }

    public function lstCommandesClient()
    {
        $data["controller"]= "Commandes Client";
        $data['commandesCli']=model("\App\Models\LstCommandesCli")->getCompteCommandes();
        return view('page_accueil/lstCommandesCli.php', $data);
    }

    public function lstCommandesVendeur()
    {
        $data["controller"]= "Commandes Vendeur";
        $data['commandesVend']=model("\App\Models\LstCommandesVendeur")->findAll();
        return view('page_accueil/lstCommandesVendeur.php', $data);
    }

    public function paiement()
    {
        $post=$this->request->getPost();
        $issues=[];
        $data["controller"]='Paiement';

        //Partie copié de infoLivraison:
        
        $model=model("\App\Models\AdresseFacturation");

        $client=model("\App\Models\Client")->getClientById(session()->get("numero"));
        //dd($client);
        $post=$this->request->getPost();
        $adresse = new \App\Entities\Adresse();

        if (isset($post["utilise_nom_profil"])) {
            $data["profil_utilisee"]=true;
            unset($post["utilise_nom_profil"]);
        } else {
            $data["profil_utilisee"]=false;
        }

        $this->validator = Services::validation();
        $this->validator->setRules($model->rules);
        
        if (!empty($post)) {
            $paiement = service('authentification');
            $issues=$paiement->paiement($post);
            $adresse->fill($post);
            dd($adresse);
            if (empty($issues) && $adresse->checkAttribute($this->validator) ) {
                /* Cookie = problème de sécurité
                $expiration=strtotime('+24 hours');
                setcookie('id_adresse_facturation', $id_a, array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
                */
                $id_a=$model->enregAdresse($adresse);
                session()->set("adresse_facturation",$id_a);
                return redirect()->to("/validation");
            }
        }else if(session()->has("adresse_livraison")){
            $adresse=model("\App\Models\AdresseLivraison")->find(session()->get("adresse_livraison"));
            $data["dejaRempli"] = "Adresse livraison validée et réutilisée";
            
        }



        $data['erreurs'] = $issues;
        $data['nomCB'] = (isset($_POST['nomCB'])) ? $_POST['nomCB'] : "";
        $data['numCB'] = (isset($_POST['numCB'])) ? $_POST['numCB'] : "";
        $data['dateExpiration'] = (isset($_POST['dateExpiration'])) ? $_POST['dateExpiration'] : "";
        $data['CVC'] = (isset($_POST['CVC'])) ? $_POST['CVC'] : "";
        
        $data['adresse']=$adresse;
        
        $data['client']=$client;
        $data['errors']=$this->validator;
        $data["formAdresse"]=view("formAdresse.php",$data);
        return view('page_accueil/paiement.php', $data);
    }

    public function detail($num_commande, $estVendeur=false)
    {
        $data["controller"]= "Détail Commande";
        $data['numCommande'] = $num_commande;
        $data['infosCommande']=model("\App\Models\LstCommandesCli")->getCommandeById($num_commande);
        $data['articles']=model("\App\Models\DetailsCommande")->getArticles($num_commande);
        if (!isset($data['infosCommande'][0]->num_commande)) {
            throw new Exception("Le numéro de commande entré n'existe pas.", 404);
        } else if (!$estVendeur && $data['infosCommande'][0]->num_compte != session()->get("numero")){
            throw new Exception("Cette commande n'est pas associé à votre compte.", 404);
        } else {
            $data['num_compte'] = $data['infosCommande'][0]->num_compte;
        }
        $data['adresse']=model("\App\Models\AdresseLivraison")->getByCommande($data['numCommande']);

        return view('panier/details.php', $data);
    }

    public function validation(){
        $data['controller']="Validation";
        if(session()->has("adresse_facturation") && session()->has("adresse_livraison")){
            $get=$this->request->getGet();
            if(isset($get["Confirmation"]) && $get["Confirmation"]==1){
                model("\App\Models\LstCommandesCli")->creerCommande(session()->get("numero"),session()->get("adresse_livraison"));
                session()->remove("adresse_livraison");
                session()->remove("adresse_facturation");
                return redirect()->to("/commandes");
            }
            else{
                $data["adresseLivr"]=model("\App\Models\AdresseLivraison")->find(session()->get("adresse_livraison"));
                $data["adresseFact"]=model("\App\Models\AdresseFacturation")->find(session()->get("adresse_facturation"));
                $data['produits'] = model("\App\Models\ProduitPanierCompteModel")->getPanier(session()->get("numero"));
                $client= model("\App\Models\Client")->find(session()->get("numero"));
                $panier=model("\App\Models\ReducPanier")->getReducByPanier($client->current_panier);
                if(!empty($panier)){
                    $codeReduc = model("\App\Models\CodeReduction")->getCodeReducById($panier[0]->id_reduction)[0];
                }
                if(isset($codeReduc))
                {
                    if ($codeReduc->montant_reduction != 0)
                    {
                        $data['reducMont'] = $codeReduc->montant_reduction;
                    }
                    else
                    {
                        $data['reducPourc'] = $codeReduc->pourcentage_reduction;
                    }
                }
                $data['totalTtc']= array_sum(array_map(fn($produit) => $produit->prixTtc,$data['produits']));
                $data['totalHt']= array_sum(array_map(fn($produit) => $produit->prixHt,$data['produits']));
                return view("recapitulatif.php",$data);
            }
            
            
        }
        else throw new Exception("Vous ne pouvez pas être a cette étape sans avoir valider votre panier et vos adresses de factutation et de livraison",401);
    }

    //Tant que commande n'est pas là
    public function commandeTest()
    {
        echo "oui";
    }
}