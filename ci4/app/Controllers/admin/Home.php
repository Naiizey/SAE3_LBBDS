<?php

namespace App\Controllers\admin;

use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use Exception;

class Home extends BaseController
{
    public $feedback;

    public function index()
    {
        $data["role"] = "admin";
        $data["controller"] = "Administration";

        return view("admin/index.php", $data);
    }

    public function destroySession()
    {
        $session=session();
        $session->remove("numero");
        $session->remove("nom");
        $session->remove("ignorer");
        $session->remove("adresse_facturation");
        $session->remove("adresse_livraison");
        $session->set("just_deconnectee",True);
        
        return redirect()->to("/");
    }

    public function lstSignalements($id_signal = null)
    {
        if ($id_signal != null)
        {
            $modelSignalements = model("\App\Models\LstSignalements");
            $modelSignalements->delete($id_signal);
        }
        
        $data["role"] = "admin";
        $data["controller"] = "Administration - Signalements";
        $data["signalements"] = model("\App\Models\LstSignalements")->findAll();
        $data["produitSignalements"] = array();
        $modelCommentaires = model("\App\Models\LstAvis");

        for ($i = 0; $i < count($data["signalements"]); $i++)
        {
            //On récupère tous les champs de l'avis signalé
            $data["produitSignalements"][$i] = $modelCommentaires->getAvisById($data["signalements"][$i]->num_avis);
            
            //On s'intéresse particulièrement à l'id produit
            $data["produitSignalements"][$i] = $data["produitSignalements"][$i]->id_prod;
        }

        return view("admin/lstSignalements.php", $data);
    }

    public function lstClients($which)
    {
        $data["controller"]="Liste des clients";
        $data["role"]="admin";
        $data["clients"]=model("\App\Models\Client")->findAll();

        if ($which=="bannir") {
            $data["bannir"]=true;

            $post=$this->request->getPost();

            if (!empty($post)){
                $sanctions = model("\App\Models\SanctionTemp");
                if ($sanctions->isTimeout($post["numClient"])) {
                    $GLOBALS['invalidation'] = $this->feedback->afficheInvalidation("Cet utilisateur est déjà banni !");
                } else {
                    $sanctions->ajouterSanction($post["raison"],$post["numClient"],$post["duree"]);
                    $GLOBALS['validation'] = $this->feedback->afficheValidation("L'utilisateur a été banni !");
                }
            }
        }
        return view("admin/lstClients.php", $data);
    }

    public function lstAvis($id_avis = null)
    {
        if ($id_avis != null)
        {
            $modelAvis = model("\App\Models\LstAvis");
            $modelAvis->delete($id_avis);
        }
        
        $data["role"] = "admin";
        $data["controller"] = "Administration - Avis";
        $data["avis"] = model("\App\Models\LstAvis")->findAll();

        return view("admin/lstAvis.php", $data);
    }

    public function lstVendeurs()
    {
        $data["controller"]="Liste des vendeurs";
        $data["role"]="admin";
        $data["vendeurs"]= array(); //model("\App\Models\Vendeur")->findAll();

        return view("admin/lstVendeurs.php", $data);
    }

    public function bannissements()
    {
        $post = $this->request->getPost();
        if (!empty($post))
        {
            $modelSanctionTemp = model("\App\Models\SanctionTemp");
            $modelSanctionTemp->delete($post["id_bannissement"]);
            $GLOBALS['validation'] = $this->feedback->afficheValidation("Cet utilisateur n'est plus banni !");
        }

        $data["controller"]="Liste des bannissements";
        $data["role"]="admin";
        $data["bannissements"]=model("\App\Models\SanctionTemp")->TimeoutsActuels();

        return view("admin/bannissements.php",$data);
    }

    public function inscriptionVendeur()
    {
        $post=$this->request->getPost();
        $issues=[];

        if (!empty($post)) 
        {
            //Vérification des champs du post (attributs de l'entité Client) + confirmation mot de passe
            $auth = service('authentification');
            $user= new \App\Entities\Vendeur();
            $user->fill($post);
            $issues=$auth->inscriptionVendeur($user, $post['confirmezMotDePasse']);

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
        
        $data['role'] = "admin";
        $data["controller"]= "Inscription Vendeur";
        $data['erreurs'] = $issues;

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['identifiant'] = (isset($_POST['identifiant'])) ? $_POST['identifiant'] : "";
        $data['email'] = (isset($_POST['email'])) ? $_POST['email'] : "";
        $data['motDePasse'] = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : "";
        $data['confirmezMotDePasse'] = (isset($_POST['confirmezMotDePasse'])) ? $_POST['confirmezMotDePasse'] : "";

        return view('vendeur/inscription.php', $data);
    }

    public function profil($numClient)
    {
        $data["controller"] = "Profil Client";
        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelClient = model("\App\Models\Client");
        $post=$this->request->getPost();

        $data['numClient'] = $numClient;

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

        //Pré-remplissage des champs avec les données de la base
        $data['pseudo'] = $client->identifiant;
        $data['prenom'] = $client->prenom;
        $data['nom'] = $client->nom;
        $data['email'] = $client->email;
        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numero"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numero"));
        $data['erreurs'] = $issues;

        return view('admin/profil.php', $data);
    }
}