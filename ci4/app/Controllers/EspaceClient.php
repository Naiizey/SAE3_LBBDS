<?php namespace App\Controllers;

class EspaceClient extends BaseController
{
    public function index()
    {
        return view('page_accueil/index.php');
    }

    public function verification(){
        $auth = service('authentification');
        $verif=$auth->connexion($this->request->getPost()); 
        if($verif){
            return redirect()->to("/");
        }
        else{
            return redirect()->to("/connexion/400");
        }
        
    }
}
