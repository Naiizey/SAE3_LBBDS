<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function connexion()
    {
        $clientModel = model("\App\Models\Client");
        $data['prod'] = $clientModel->find(1);
        return view('page_accueil/connexion.php',$data);
    }


}
