<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['controller']= "index";
        return view('page_accueil/index.php',$data);
    }

    public function connexion($context = null)
    {
        $data['controller']= "connexion";
        if($context == 400){
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        $clientModel = model("\App\Models\Client");
        $data['prod'] = $clientModel->find(1);
        return view('page_accueil/connexion.php',$data);
    }

    public function inscription($context = null)
    {
        $data['controller']= "connexion";
        if($context == 400){
            $data['error']="<p class='erreur'>Erreur d'authentification</p>";
        }
        $clientModel = model("\App\Models\Client");
        $data['prod'] = $clientModel->find(1);
        return view('page_accueil/inscription.php',$data);
    }
}
