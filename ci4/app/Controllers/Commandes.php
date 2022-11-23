<?php

namespace App\Controllers;

class Commandes extends BaseController
{

    public function __construct()
    {
        //permer d'éviter le bug de redirection.
        session();

    }

    public function index()
    {
        $data['controller']= "index";
        return view('panier/index.php',$data);
    }

    public function detail($num_commande)
    {
        $data['controller']= "detail";
        
        return view('panier/details.php',$data);
    }
    
    //Tant que commande n'est pas là
    public function commandeTest(){
        
        echo "oui";
    }
}
