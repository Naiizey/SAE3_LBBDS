<?php

namespace App\Controllers;

class UserHandler extends BaseController
{

    public function connexion()
    {
        $clientModel = model("\App\Models\Client");
        $entree=$this->request->getPost();
        print_r($clientModel->where('pseudo',$entree['identifiant'])->where('mdp',$entree['motDePasse'])->findAll()[0]);
        
    }


}
