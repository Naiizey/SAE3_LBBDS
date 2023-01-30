<?php

namespace App\Controllers\vendeur;

use CodeIgniter\Config\Services;
use CodeIgniter\Validation\Validation;
use App\Controllers\BaseController;
use Exception;

class Vendeur extends BaseController
{
    public $feedback;

    public function __construct()
    {
        //Permets d'éviter le bug de redirection.
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
        $data['prods']=model("\App\Models\ProduitCatalogue")->findAll();

        if (session()->has("numero")) {
            $data['quant'] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
        } elseif (has_cookie("token_panier")) {
            $data['quant'] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token"));
        } else {
            $data['quant'] = 0;
        }

        return view('client/index.php', $data);
    }

    public function lstCommandesVendeur($estVendeur=false)
    {
        $data["controller"]= "Commandes Vendeur";
        $data['commandesVend']=model("\App\Models\LstCommandesVendeur")->findAll();
        $data['estVendeur']=$estVendeur;
        return view('admin/lstCommandesVendeur.php', $data);
    }
}