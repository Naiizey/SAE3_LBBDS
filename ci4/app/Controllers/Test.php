<?php namespace App\Controllers;

use App\Controllers\BaseController;

class Test extends BaseController{

        public function destroySession(){
            $session=session();
            $session->destroy();
        }

        public function test()
        {
            $prodModel=model("\App\Models\Produit");
            return view('card-produit.php');
        }

        public function test2()
        {
            $session= session();
            
            echo $session->get('identifiant');
        }
}
