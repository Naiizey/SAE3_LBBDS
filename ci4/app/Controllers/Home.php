<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('page_accueil/index.php');
    }

    public function connexion()
    {
        $clientModel = model("\App\Models\Client");
        $data['prod'] = $clientModel->find(1);
        return view('page_accueil/connexion.php',$data);
    }

    public function test()
    {
        $prodModel=model("\App\Models\Produit");
        return view('card-produit.php');
    }
}
