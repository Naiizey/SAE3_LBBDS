<?php namespace App\Controllers;

use App\Controllers\BaseController;

class Test extends BaseController{

        public function destroySession(){
            $session=session();
            $session->destroy();
        }

        public function test()
        {
            $data['cardProduit']=service("cardProduit");

            $prodModel=model("\App\Models\ProduitCatalogue");
            $data['prod']=$prodModel->find(17);
        
            return view('card-produit-exemple.php',$data);
        }

        public function test2()
        {
            $session= session();
            
            echo $session->get('identifiant');
        }

        public function test3()
        {
            print_r(model("\App\Models\ProduitPanierModel")->getPanierFromClient(1));
        }
}
