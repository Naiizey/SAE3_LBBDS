<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index()
    {
        return view('page_accueil/index.php');
    }

    public function connection($num=null){
        $num="ef";
        return view('page_accueil/connexion.php');
    }
}
