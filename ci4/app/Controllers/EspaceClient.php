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

    public function enregistrement(){
        $auth = service('authentification');
        $post=$this->request->getPost();
        $user= new \App\Entities\Client();
        $user->fill($post);
        $issues=$auth->inscription($user,$post['confirmezMotDePasse']); 

        if(empty($issues)){
            return redirect()->to("/");
        }
        else{
            session()->set("errors",$issues);
            return redirect()->to("/inscription");
        }
        
    }
}
