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
        return view('page_accueil/connexion.php');
    }

    public function test()
    {
        return view('card-produit.php');
    }
}
