<?php

namespace App\Controllers;

use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use Exception;

abstract class HomeGlobal extends BaseController
{
    public $feedback;
    public $context;

    protected function _produit($entityUser, $sessionType, $view, $nomCookiePanier=null, $idProduit = null, $numAvisEnValeur = null)
    {
        $estAdmin=(is_null($entityUser) && $this->context="admin");
        $data["context"]=$this->context;
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
        if (!$estAdmin && session()->has($sessionType)) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierCompteModel")->getQuantiteProduitByIdProd($idProduit, session()->get($sessionType));
        } elseif (!is_null($nomCookiePanier) && has_cookie($nomCookiePanier)) {
            $data["quantitePanier"]=model("\App\Models\ProduitPanierVisiteurModel")->getQuantiteProduitByIdProd($idProduit, get_cookie($nomCookiePanier));
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
        if(!$estAdmin){
            //Post des avis
            $post=$this->request->getPost();
            $data["erreurs"] = [];
            $commandesCli = model("\App\Models\LstCommandesCli")->getCompteCommandes();
            $articles = model("\App\Models\DetailsCommande")->getArticles(session()->get($sessionType));
        }
       

        if (!empty($post) && !$estAdmin) 
        {
            //Si la raison du reload avec post est due à un signalement
            if (isset($post['raison']) )
            {
                //Création du signalement
                $signal = new \App\Entities\Signalement();
                $signal->raison = $post['raison'];
                $signal->num_avis = $post['num_avis'];
                $signal->num_compte = session()->get($sessionType);
                model("\App\Models\LstSignalements")->save($signal);

                session()->set("just_signal", true);
            }
            //Sinon elle est due à un avis
            else
            {
                //Vérifie que la session (donc l'utilisateur) n'a pas déjà commenté cet article.
                foreach ($data['avis'] as $unAvis) {
                    if (session()->get($sessionType) == $unAvis->num_compte) {
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
                if (empty($data["erreurs"]) && !$estAdmin) 
                {
                    $avis = new \App\Entities\Avis();
                    $avis->contenu_av = $post['contenuAvis'];
                    $avis->id_prod = $idProduit;
                    $avis->num_compte = session()->get($sessionType);
                    $avis->note_prod = $post['noteAvis'];
                    $avis->pseudo = $entityUser->identifiant;
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
                return view("produit.php", $data);
            }
        }
    }
}

 