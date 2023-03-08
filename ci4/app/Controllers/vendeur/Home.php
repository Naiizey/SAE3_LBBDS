<?php

namespace App\Controllers\vendeur;

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
        $data['prods']=model("\App\Models\ProduitCatalogueVendeur")->findAll();

        return view('client/index.php', $data);
    }

    public function lstCommandes($num_commande = null)
    {
        $data["controller"] = "Commandes Client";
        $estVendeur = true;
        if ($num_commande == null)
        {
            $data['commandesVendeur']=model("\App\Models\LstCommandesVendeur")->getCompteCommandes();
            return view('vendeur/commande/lstCommandes.php', $data);
        }
        else
        {
            $data['numCommande'] = $num_commande;
            $data['infosCommande']=model("\App\Models\LstCommandesCli")->getCommandeById($num_commande);
            $data['articles']=model("\App\Models\DetailsCommande")->getArticles($num_commande);
            $data['estVendeur']=$estVendeur;

            if (!isset($data['infosCommande'][0]->num_commande)) {
                throw new Exception("Le numéro de commande renseigné n'existe pas.", 404);
            } 
            else 
            {
                $data['num_compte'] = $data['infosCommande'][0]->num_compte;
            }
            $data['adresse']=model("\App\Models\AdresseLivraison")->getByCommande($data['numCommande']);
        
            return view('vendeur/commande/details.php', $data);
        }
    }

    public function profil()
    {
        $data["controller"] = "Profil Vendeur";
        $modelVendeur = model("\App\Models\Vendeur");
        $post=$this->request->getPost();
        
        $numVendeur = session()->get("numeroVendeur");
        $data['numVendeur'] = $numVendeur;

        $issues = [];
        $vendeur = $modelVendeur->getVendeurById($numVendeur);

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
            $user=$vendeur;
            $user->fill($post);
            $issues=$auth->modifProfilVendeur($user, $post["confirmezMotDePasse"], $post['nouveauMotDePasse']);

            if (!empty($issues))
            {
                //En cas d'erreur(s), on pré-remplit les champs avec les données déjà renseignées
                $data["motDePasse"] = $post["motDePasse"];
                $data["confirmezMotDePasse"] = $post["confirmezMotDePasse"];
                $data['nouveauMotDePasse'] = $post['nouveauMotDePasse'];
            }
            else
            {
                return redirect()->to("/vendeur/profil");
            }
        }

        //Pré-remplissage des champs avec les données de la base
        $data["identifiant"] = $vendeur->identifiant;
        $data["txtPres"] = $vendeur->texte_presentation;
        $data["logo"] = $vendeur->logo;
        $data["note"] = $vendeur->note_vendeur;
        $data["email"] = $vendeur->email;
        $data["siret"] = $vendeur->numero_siret;
        $data["tvaInterCom"] = $vendeur->tva_intercommunautaire;
        $data["numRue"] = $vendeur->numero_rue;
        $data["nomRue"] = $vendeur->nom_rue;
        $data["ville"] = $vendeur->ville;
        $data["codePostal"] = $vendeur->code_postal;
        $data["compA1"] = $vendeur->comp_a1;
        $data["compA2"] = $vendeur->comp_a2;
        $data["erreurs"] = $issues;
        $data["noteVendeur"]=service("cardProduit")->notationEtoile($vendeur->note_vendeur);

        return view('vendeur/profil.php', $data);
    }

    public function connexion()
    {
        $post=$this->request->getPost();
        $issues=[];

        if (!empty($post)) 
        {
            //Vérification des champs du post (attributs de l'entité Client)
            $auth = service('authentification');
            $user= new \App\Entities\Vendeur();
            $user->fill($post);
            $issues=$auth->connexionVendeur($user);

            if(empty($issues))
            {
                if (!session()->has("referer_redirection")) 
                {
                    return redirect()->to("/vendeur/profil");
                } 
                else 
                {
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

        return view('vendeur/connexion.php', $data);
    }

    public function produit($idProduit = null, $numAvisEnValeur = null)
    {
        $data["idProduit"] = $idProduit;
        $data["signalements"] = model("\App\Models\LstSignalements")->findAll();
        $data['model'] = model("\App\Models\ProduitCatalogueVendeur");
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
        if (session()->has('numero')) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierCompteModel")->getQuantiteProduitByIdProd($idProduit, session()->get('numero'));
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
        $articles = model("\App\Models\DetailsCommande")->getArticles(session()->get("numero"));
        $vendeur = model("\App\Models\Vendeur")->getVendeurById(session()->get("numeroVendeur"));

        if (!empty($post)) 
        {
            //Si la raison du reload avec post est due à un signalement
            if (isset($post['raison']))
            {
                //Création du signalement
                $signal = new \App\Entities\Signalement();
                $signal->raison = $post['raison'];
                $signal->num_avis = $post['num_avis'];
                $signal->num_compte = session()->get("numero");
                model("\App\Models\LstSignalements")->save($signal);

                session()->set("just_signal", true);
            }
            //Sinon elle est due à un avis
            else
            {
                //Vérifie que la session (donc l'utilisateur) n'a pas déjà commenté cet article.
                foreach ($data['avis'] as $unAvis) {
                    if (session()->get("numero") == $unAvis->num_compte) {
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
                    $avis->num_compte = session()->get("numero");
                    $avis->note_prod = $post['noteAvis'];
                    $avis->pseudo = $vendeur->identifiant;
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
                return view('vendeur/produit.php', $data);
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
        $modelProduitCatalogue=model("\App\Models\ProduitCatalogueVendeur");

        //Récupération des cartes produits
        $data['cardProduit']=service("cardProduit");

        //Chargement du modèle Categorie dans le tableau data pour l'utiliser dans la vue
        $data['categories']=model("\App\Models\CategorieModel")->findAll();

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
        $result=(new \App\Controllers\vendeur\Produits())->getAllProduitSelonPage($page, self::NBPRODSPAGECATALOGUE, $filters);
        $data['prods']=$result["resultat"];
        $data['estDernier']=$result["estDernier"];
        
        //Si la page est vide, on affiche un message
        if (!isset($data['prods']) || empty($data['prods'])) {
            $data['message'] = "Vous n'avez pas encore de produits dans votre catalogue.";
        }
        return view("vendeur/catalogue.php", $data);
    }
}