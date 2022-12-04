<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use Config\Services;
use Exception;

class MdpOublie extends BaseController
{
    
    public function __construct()
    {
        helper('cookie');
        if (session()->has("numero")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierCompteModel")->compteurDansPanier(session()->get("numero"));
        } else if (has_cookie("token_panier")) {
            $GLOBALS["quant"] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token_panier"));
        } else {
            $GLOBALS["quant"] = 0;
        }
    }

    public function mdpOublie($post = null, $data = null)
    {
        $data["controller"]= "mdpOublie";

        //Pré-remplit les champs s'ils ont déjà été renseignés juste avant des potentielles erreurs
        $data['email'] = (isset($post['email'])) ? $post['email'] : "";
        $data['code'] = (isset($post['code'])) ? $post['code'] : "";



        return view('page_accueil/mdpOublie.php', $data);
    }
 
    public function obtenirCode() 
    {
        $post=$this->request->getPost();
        $clientModel = model("\App\Models\Client");

        if ($clientModel->doesEmailExists($post['email'])) 
        {
            $data['retour'][0] = "Renseignez le code qui vous a été envoyé par mail.";
        } 
        else 
        {
            $data['retour'][1] = "L'adresse mail ne correspond à aucun compte.";
        }

        return $this->mdpOublie($post, $data);
    }   

    public function validerCode()
    {
        $post=$this->request->getPost();

        $leCodeEstBon = false;
        if ($leCodeEstBon) 
        {
            $data['retour'][3] = "Votre mot de passe a bien été réinitialisé.";
        } 
        else 
        {
            $data['retour'][4] = "Erreur, code invalide.";
        }
        return $this->mdpOublie($post, $data);
    }
}