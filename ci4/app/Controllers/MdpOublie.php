<?php namespace App\Controllers;

use CodeIgniter\CodeIgniter;
use Config\Services;
use Exception;

class MdpOublie extends BaseController
{
    public function mdpOublie()
    {
        $data['controller']= "mdpOublie";
        return view('page_accueil/mdpOublie.php', $data);
    }

    public function obtenirCode() {
        $post=$this->request->getPost();
        $clientModel = model("\App\Models\Client");

        if(!empty($post))
        {
            $user= new \App\Entities\Client();
            $user->fill($post);
        }

        if ($clientModel->doesEmailExists($_POST['email'])) {
            $retour="Renseignez le code qui vous a été envoyé par mail.";
        } else {
            $retour="L'adresse mail ne correspond à aucun compte.";
        }

        return $retour;
    }
}