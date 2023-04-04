<?php namespace App\Controllers\Vendeur;


use App\Controllers\BaseQuidi;


class Quidi extends BaseQuidi
{


    public function __construct()
    {
        parent::__construct();
        $this->context="vendeur";
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