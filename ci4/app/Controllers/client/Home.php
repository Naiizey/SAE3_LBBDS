<?php

namespace App\Controllers\client;

use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use Exception;

class Home extends BaseController
{
    public $feedback;

    public function __construct()
    {
        //Permets d'éviter le bug de redirection.
        session();

        //Affichage de la quantité panier
        helper('cookie');

        if (session()->has("numeroClient")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numeroClient"));
        } elseif (has_cookie("token_panier")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token_panier"));
        } else {
            $GLOBALS["quant"] = 0;
        }

        //Au cas où __ci_previous_url ne marcherait plus...: session()->set("previous_url",current_url());
        $this->feedback=service("feedback");
        if (session()->has("just_connectee") && session()->get("just_connectee")==true) {
            session()->set("just_connectee", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Vous êtes connecté !");
        } else if (session()->has("just_deconnectee") && session()->get("just_deconnectee")==true) {
            session()->set("just_deconnectee", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Vous êtes déconnecté !");
        } else if (session()->has("just_signal") && session()->get("just_signal")==true) {
            session()->set("just_signal", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Avis signalé !");
        }
        
        $this->verifTimeout();
    }

    public function index()
    {
        $data["controller"]= "Accueil";

        //Feedback article ajouté
        if(session()->has("just_ajoute") && session()->get("just_ajoute") == true) {
            $this->feedback=service("feedback");
            session()->set("just_ajoute", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Article ajouté");
        }

        $data['cardProduit']=service("cardProduit");
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();

        if (session()->has("numeroClient")) {
            $data['quant'] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numeroClient"));
        } elseif (has_cookie("token_panier")) {
            $data['quant'] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token"));
        } else {
            $data['quant'] = 0;
        }

        return view('client/index.php', $data);
    }

    public function connexion()
    {
        $post=$this->request->getPost();
        $issues=[];

        if (!empty($post))
        {
            //Vérification des champs du post (attributs de l'entité Client)
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->connexionClient($user);

            if(empty($issues))
            {
                if (!session()->has("referer_redirection")) {
                    return redirect()->to("/");
                } else {
                    $redirection=session()->get("referer_redirection");
                    session()->remove("referer_redirection");
                    return redirect()->to($redirection);
                }
            }
        }

        if (session()->has("referer_redirection")) {
            $data['linkRedirection']=session()->get("referer_redirection");
            $issues['redirection']="Vous devez vous connectez pour y accéder";
        }

        $data["controller"]= "Connexion";
        $data["erreurs"] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data["identifiant"] = (isset($_POST["identifiant"])) ? $_POST["identifiant"] : "";
        $data["motDePasse"] = (isset($_POST["motDePasse"])) ? $_POST["motDePasse"] : "";

        // Se souvenir de moi
        if (isset($_POST['rememberMe'])) {
            dd($_POST["rememberMe"]);
        }
        
        //set_cookie($cookie);
        return view('client/connexion.php', $data);
    }

    public function inscription()
    {
        $post=$this->request->getPost();
        $issues=[];

        if (!empty($post)) 
        {
            //Vérification des champs du post (attributs de l'entité Client) + confirmation mot de passe
            $auth = service('authentification');
            $user= new \App\Entities\Client();
            $user->fill($post);
            $issues=$auth->inscriptionClient($user, $post["confirmezMotDePasse"]);

            if (empty($issues))
            {
                if (!session()->has("referer_redirection")) {
                    return redirect()->to("/");
                } else {
                    $redirection=session()->get("referer_redirection");
                    session()->remove("referer_redirection");
                    return redirect()->to($redirection);
                }
            }
        }
        
        if (session()->has("referer_redirection")) 
        {
            $data['linkRedirection']=session()->get("referer_redirection");
            if (parse_url($data['linkRedirection']) === "livraison") {
                $issues['redirection']="Vous devez vous connectez pour valider votre commande";
                $data["controller"]= "Compte Redirection";
            } else {
                $issues['redirection']="Vous devez vous connectez pour accéder à cette espace";
                $data["controller"]= "Inscription Client";
            }
        } 
        else 
        {
            $data["controller"]= "Inscription Client";
        }

        $data["erreurs"] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['pseudo'] = (isset($_POST['pseudo'])) ? $_POST['pseudo'] : "";
        $data['nom'] = (isset($_POST['nom'])) ? $_POST['nom'] : "";
        $data['prenom'] = (isset($_POST['prenom'])) ? $_POST['prenom'] : "";
        $data["email"] = (isset($_POST["email"])) ? $_POST["email"] : "";
        $data["motDePasse"] = (isset($_POST["motDePasse"])) ? $_POST["motDePasse"] : "";
        $data["confirmezMotDePasse"] = (isset($_POST["confirmezMotDePasse"])) ? $_POST["confirmezMotDePasse"] : "";

        return view('client/inscription.php', $data);
    }

    public function produit($idProduit = null, $numAvisEnValeur = null)
    {
        $data["idProduit"] = $idProduit;
        $data["signalements"] = model("\App\Models\LstSignalements")->findAll();
        $data['model'] = model("\App\Models\ProduitCatalogue");
        $data['cardProduit']=service("cardProduit");
        
        //Gestion du feedback
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
        if (session()->has("numeroClient")) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierCompteModel")->getQuantiteProduitByIdProd($idProduit, session()->get("numeroClient"));
        } elseif (has_cookie('token_panier')) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierVisiteurModel")->getQuantiteProduitByIdProd($idProduit, get_cookie('token_panier'));
        }

        //Autres images du produit
        $prodModelAutre = model("\App\Models\ProduitDetailAutre");
        $autresImages = $prodModelAutre->getAutresImages($idProduit);

        if (!empty($autresImages))
        {
            $data['autresImages'] = $autresImages;
        }

        //Avis/commentaires
        $data['cardProduit']=service("cardProduit");
        $data['avis']=model("\App\Models\LstAvis")->getAvisByProduit($idProduit);

        //Post des avis
        $post=$this->request->getPost();
        $data["erreurs"] = [];
        $commandesCli = model("\App\Models\LstCommandesCli")->getCompteCommandes();
        $articles = model("\App\Models\DetailsCommande")->getArticles(session()->get("numeroClient"));
        $client = model("\App\Models\Client")->getClientById(session()->get("numeroClient"));

        if (!empty($post)) 
        {
            //Si la raison du reload avec post est due à un signalement
            if (isset($post['raison']))
            {
                //Création du signalement
                $signal = new \App\Entities\Signalement();
                $signal->raison = $post['raison'];
                $signal->num_avis = $post['num_avis'];
                $signal->num_compte = session()->get("numeroClient");
                model("\App\Models\LstSignalements")->save($signal);

                session()->set("just_signal", true);
            }
            //Sinon elle est due à un avis
            else
            {
                //Vérifie que la session (donc l'utilisateur) n'a pas déjà commenté cet article.
                foreach ($data['avis'] as $unAvis) {
                    if (session()->get("numeroClient") == $unAvis->num_compte) {
                        $data["erreurs"][0] = "Vous avez déjà commenté ce produit.";
                    }
                }

                //Vérifie que l'utilisateur a déjà acheté ce produit
                $dejaAchete = false;
                foreach ($commandesCli as $commande) {
                    foreach ($articles as $article) {
                        if ($article->id_prod == $idProduit) {
                            $dejaAchete = true;
                        }
                    }
                }

                //S'il n'a jamais acheté : erreur
                if ($dejaAchete == false) {
                    $data["erreurs"][1] = "Vous ne pouvez pas commenter un produit que vous n'avez jamais acheté.";
                }

                //S'il n'y a pas d'erreurs, on enregistre l'avis
                if (empty($data["erreurs"])) 
                {
                    $avis = new \App\Entities\Avis();
                    $avis->contenu_av = $post['contenuAvis'];
                    $avis->id_prod = $idProduit;
                    $avis->num_compte = session()->get("numeroClient");
                    $avis->note_prod = $post['noteAvis'];
                    $avis->pseudo = $client->identifiant;
                    model("\App\Models\LstAvis")->enregAvis($avis);
                }
            }
        }

        //Update des avis après un potentiel ajout
        $data['avis'] = model("\App\Models\LstAvis")->getAvisByProduit($idProduit);

        //Passage de l'id de l'avis en valeur si il y en a un à la vue
        if ($numAvisEnValeur != null) {
            $data['avisEnValeur'] = $numAvisEnValeur;
        } else {
            $data["avisEnValeur"] = -1;
        }
        
        //Synchronisation des produits avec la base
        $result = model("\App\Models\ProduitDetail")->find($idProduit);

        //Affichage selon si produit trouvé ou non
        if ($result == null) {
            return view('errors/html/error_404.php', array('message' => "Ce produit n'existe pas"));
        } else {
            $data["controller"] = "Produit";

            $data['prod'] = $result;

            if (strstr(current_url(), "retourProduit") || isset($post['raison']))
            {
                return redirect()->to("/produit/$idProduit#avis");
            } else {
                return view('client/produit.php', $data);
            }
        }
    }

    //Nombre maximal de produits par page
    private const NBPRODSPAGECATALOGUE = 20;
    #FIXME: comportement href différent entre $page=null oe $page !=null
    
    public function catalogue($page=1) {
        if (session()->has("just_ajoute") && session()->get("just_ajoute")) {
            $this->feedback=service("feedback");
            session()->set("just_ajoute", false);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Article ajouté");
        }

        //Récupération des filtres présents dans le get
        $filters=$this->request->getGet();
        //dd($filters);
        //Ajout des filtres dans le tableau data pour les utiliser dans la vue
        $data["filters"]=$filters;

        //Chargement du modèle Produit Catalogue
        $modelProduitCatalogue=model("\App\Models\ProduitCatalogue");

        //Récupération des cartes produits
        $data['cardProduit']=service("cardProduit");

        //Chargement du modèle Categorie dans le tableau data pour l'utiliser dans la vue
        $data['categories']=model("\App\Models\CategorieModel")->findAll();

        //Chargement du modèle Vendeur dans le tableau data pour l'utiliser dans la vue
        $data['vendeurs']=model("\App\Models\Vendeur")->findAll();

        //Set du controller Catalogue pour la vue
        $data["controller"] = "Catalogue";

        //Initialisation du tableau des produits à afficher
        $data['prods'] = [];

        //Initialisation de la variable indiquant si la page est vide
        $data['vide'] = false;

        //Chargement du prix maximal dans la Base de données pour utiliser dans la vue
        $data['max_price'] = $modelProduitCatalogue->selectMax('prixttc')->find()[0]->prixttc;

        //Chargement du prix minimal dans la Base de données pour utiliser dans la vue
        $data['min_price'] = $modelProduitCatalogue->selectMin('prixttc')->find()[0]->prixttc;
        
        //Chargement des produits selon les filtres
        $result=(new \App\Controllers\client\Produits())->getAllProduitSelonPage($page, self::NBPRODSPAGECATALOGUE, $filters);
        $data['prods']=$result["resultat"];
        $data['estDernier']=$result["estDernier"];
        
        //Si la page est vide, on affiche un message
        if (!isset($data['prods']) || empty($data['prods'])) {
            $data['message'] = $result["message"];
        }
        return view("client/catalogue.php", $data);
    }
    
    public function profil()
    {
        $data["controller"] = "Profil Client";
        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelClient = model("\App\Models\Client");
        $post=$this->request->getPost();

        $numClient = session()->get("numeroClient");
        $data['numClient'] = $numClient;

        $issues = [];
        $client = $modelClient->getClientById($numClient);
        $clientBase = $modelClient->getClientById($numClient);
        $data['prenomBase'] = $clientBase->prenom;

        //Valeurs par défaut
        $data["motDePasse"] = "motDePassemotDePasse";
        $data["confirmezMotDePasse"] = "";
        $data['nouveauMotDePasse'] = "";

        //On cache par défaut les champs supplémentaires pour modifier le mdp
        $data['classCacheDiv'] = "cacheModifMdp";
        $data['disableInput'] = "disabled";
        $data['requireInput'] = "";

        //Si l'utilisateur a cherché à modifier des informations
        if (!empty($post)) 
        {
            helper('cookie');
            if (session()->has("numeroClient")) {
                $data['quant'] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numeroClient"));
            } elseif (has_cookie("token_panier")) {
                $data['quant'] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token"));
            } else {
                $data['quant'] = 0;
            }

            //Ce champ ne semble pas être défini si l'utilisateur n'y touche pas, on en informe le service
            if (!isset($post["motDePasse"])) 
            {
                $post["motDePasse"] = "motDePassemotDePasse";
            }

            //Si ces deux champs ne sont pas remplis, cela veut dire que l'utilisateur n'a pas cherché à modifier le mdp
            if (empty($post["confirmezMotDePasse"]) && empty($post['nouveauMotDePasse'])) 
            {
                //On remplit ces variables pour informer le service que nous n'avons pas besoin d'erreurs sur ces champs
                $post["confirmezMotDePasse"] = "";
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
            $issues=$auth->modifProfilClient($user, $post["confirmezMotDePasse"], $post['nouveauMotDePasse']);

            if (!empty($issues))
            {
                //En cas d'erreur(s), on pré-remplit les champs avec les données déjà renseignées
                $data["motDePasse"] = $post["motDePasse"];
                $data["confirmezMotDePasse"] = $post["confirmezMotDePasse"];
                $data['nouveauMotDePasse'] = $post['nouveauMotDePasse'];
            }
            else
            {
                return redirect()->to("/profil");
            }
        }

        //Pré-remplissage des champs avec les données de la base
        $data['pseudo'] = $client->identifiant;
        $data['prenom'] = $client->prenom;
        $data['nom'] = $client->nom;
        $data["email"] = $client->email;
        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numeroClient"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numeroClient"));
        $data["erreurs"] = $issues;

        return view('client/profil.php', $data);
    }

    public function facture()
    {
        $post=$this->request->getPost();
        $issues=[];
        $data["controller"] = 'Facture';

        //Partie copiée de infoLivraison:
        if(session()->has("numeroClient")){
            $client=model("\App\Models\Client")->getClientById(session()->get("numeroClient"));
        } else throw new Exception("Vous n'êtes pas connecté",401);

        $model = model("\App\Models\AdresseFacturation");
        
        $post = $this->request->getPost();
        $adresse = new \App\Entities\Adresse();

        if (isset($post["utilise_nom_profil"]))
        {
            $data["profil_utilisee"]=true;
            unset($post["utilise_nom_profil"]);
        }
        else
        {
            $data["profil_utilisee"]=false;
        }

        $this->validator = Services::validation();
        $this->validator->setRules($model->rules);
        
        if (!empty($post))
        {
            $adresse->fill($post);
            if (empty($issues) && $adresse->checkAttribute($this->validator))
            {
                /* Cookie = problème de sécurité
                $expiration=strtotime('+24 hours');
                setcookie('id_adresse_facturation', $id_a, array('expires'=>$expiration,'path'=>'/','samesite'=>'Strict'));
                */
                $id_a=$model->enregAdresse($adresse);
                session()->set("adresse_facturation",$id_a);
                if(session()->has("adresse_livraison")){
                    return redirect()->to("/paiement");
                }else{
                    return redirect()->to("/livraison");
                }
            }
        }
        else if(session()->has("adresse_facturation")){
            $adresse=model("\App\Models\AdresseFacturation")->find(session()->get("adresse_facturation"));
            $data["dejaRempli"] = "Adresse facture validée et réutilisée";

        }else if(session()->has("adresse_livraison"))
        {
            $adresse=model("\App\Models\AdresseLivraison")->find(session()->get("adresse_livraison"));
            $data["dejaRempli"] = "Adresse livraison validée et réutilisée";
        }

        $data['adresse']=$adresse;
        $data['client']=$client;
        $data['errors']=$this->validator;
    
        return view("client/commande/templLivraison.php",$data);
    }

    public function infoLivraison()
    {
        //Assertion Début
        if (!session()->has("numeroClient")) {
            throw new Exception("Erreur, vous devez être connecté ", 401);
        }

        $model=model("\App\Models\AdresseLivraison");
        $client=model("\App\Models\Client")->getClientById(session()->get("numeroClient"));
        $data["controller"] = "Livraisons";
        $post = $this->request->getPost();
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
                if(session()->has("adresse_facturation")){
                    return redirect()->to("/paiement");
                }else{
                    return redirect()->to("/facture");
                }
            }
        } else if(session()->has("adresse_livraison")){
            $adresse=model("\App\Models\AdresseLivraison")->find(session()->get("adresse_livraison"));
            $data["dejaRempli"] = "Adresse livraison validée et réutilisée";
            
        } else if(session()->has("adresse_facturation")){
            $adresse=model("\App\Models\AdresseFacturation")->find(session()->get("adresse_facturation"));
            $data["dejaRempli"] = "Adresse facture validée et réutilisée";
        }

        $data['adresse']=$adresse;
        $data['client']=$client;
        $data['errors']=$this->validator;
        
        return view('client/commande/templLivraison.php', $data);
    }

    public function paiement()
    {
        $post=$this->request->getPost();
        $issues=[];
        $data["controller"]='Paiement';

        //Partie copiée de infoLivraison:
        if(session()->has("numeroClient")){
            $client=model("\App\Models\Client")->getClientById(session()->get("numeroClient"));
        } else throw new Exception("Vous n'êtes pas connecté",401);
        
        $post=$this->request->getPost();

        $this->validator = Services::validation();
        if (!empty($post)) {
            $paiement = service('authentification');
            $issues=$paiement->paiement($post);
            if (empty($issues)) {
                return redirect()->to("/validation");
            }
        }
        
        //Pré-remplissage des champs avec les données du post
        $data["erreurs"] = $issues;
        $data['nomCB'] = (isset($_POST['nomCB'])) ? $_POST['nomCB'] : "";
        $data['numCB'] = (isset($_POST['numCB'])) ? $_POST['numCB'] : "";
        $data['dateExpiration'] = (isset($_POST['dateExpiration'])) ? $_POST['dateExpiration'] : "";
        $data['CVC'] = (isset($_POST['CVC'])) ? $_POST['CVC'] : "";
        $data['client']=$client;
        $data['errors']=$this->validator;
        return view('client/commande/paiement.php', $data);
    }

    public function lstCommandes($num_commande = null)
    {
        $data["controller"]= "Commandes Client";
        $estVendeur = false;
        if ($num_commande == null)
        {
            $data['commandesCli']=model("\App\Models\LstCommandesCli")->getCompteCommandes();
            return view('client/commande/lstCommandes.php', $data);
        }
        else
        {
            $data['numCommande'] = $num_commande;
            $data['infosCommande']=model("\App\Models\LstCommandesCli")->getCommandeById($num_commande);
            $data['articles']=model("\App\Models\DetailsCommande")->getArticles($num_commande);
            $data['estVendeur']=$estVendeur;

            if (!isset($data['infosCommande'][0]->num_commande)) {
                throw new Exception("Le numéro de commande renseigné n'existe pas.", 404);
            } else if (!$estVendeur && $data['infosCommande'][0]->num_compte != session()->get("numeroClient")){
                throw new Exception("Cette commande n'est pas associée à votre compte.", 404);
            } else {
                $data['num_compte'] = $data['infosCommande'][0]->num_compte;
            }
            $data['adresse']=model("\App\Models\AdresseLivraison")->getByCommande($data['numCommande']);
        
            return view('client/commande/details.php', $data);
        }
    }

    public function validation()
    {
        $data['controller']="Validation";

        if(session()->has("adresse_facturation") && session()->has("adresse_livraison"))
        {
            $get=$this->request->getGet();
            if(isset($get["Confirmation"]) && $get["Confirmation"]==1)
            {
                model("\App\Models\LstCommandesCli")->creerCommande(session()->get("numeroClient"),session()->get("adresse_livraison"));
                session()->remove("adresse_livraison");
                session()->remove("adresse_facturation");
                return redirect()->to("/commandes");
            }
            else
            {
                $data["adresseLivr"]=model("\App\Models\AdresseLivraison")->find(session()->get("adresse_livraison"));
                $data["adresseFact"]=model("\App\Models\AdresseFacturation")->find(session()->get("adresse_facturation"));
                $data['produits'] = model("\App\Models\ProduitPanierCompteModel")->getPanier(session()->get("numeroClient"));
                $client= model("\App\Models\Client")->find(session()->get("numeroClient"));
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
                return view("client/commande/recapitulatif.php", $data);
            }
        }
        else throw new Exception("Vous n'avez pas validé votre panier, vos adresses de facturation et de livraison",401);
    }

    //Fonction qui vérifie si le compte est banni
    public function verifTimeout(){
        if (session()->get("numeroClient")!=NULL) {
            if(model("\App\Models\SanctionTemp")->isTimeout(session()->get("numeroClient"))){
                $num=session()->get("numeroClient");
                $session=session();
                $session->remove("numeroClient");
                $session->remove("nomClient");
                $session->remove("ignorer");
                $session->remove("adresse_facturation");
                $session->remove("adresse_livraison");
                $session->set("just_deconnectee",False);
                $GLOBALS['invalidation'] = $this->feedback->afficheInvalidation("Vous avez été banni, il reste ".model("\App\Models\SanctionTemp")->getTimeLeft($num)." !");
                return redirect()->to("/");
            }
        }
    }
}