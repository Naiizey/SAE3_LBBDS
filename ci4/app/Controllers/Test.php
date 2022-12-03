<?php namespace App\Controllers;

use App\Controllers\BaseController;

class Test extends BaseController{

        public function destroySession(){
            $session=session();
            $session->remove("numero");
            $session->remove("nom");
            $session->remove("ignorer");
            return redirect()->to("/");
        }

        public function test()
        {
            $data['cardProduit']=service("cardProduit");
            helper('cookie');
            if (session()->has("numero")) {
                $data['quant'] = model("\App\Model\ProduitPanieCompteModel")->compteurDansPanier(session()->get("numero"));
            } else if (has_cookie("token_panier")) {
                $data['quant'] = model("\App\Model\ProduitPanierVisiteurModel")->compteurDansPanier(get_cookie("token"));
            } else {
                $data['quant'] = 0;
            }
            $prodModel=model("\App\Models\ProduitCatalogue");
            $data['prod']=$prodModel->find(17);
        
            return view('card-produit-exemple.php',$data);
        }

        public function test2()
        {
           
            
            ob_start();?>
                
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/style.css" />
          
                <style>
                    main,body {
                        background-color: black;
                    }
                   

                    
                   
                </style>
                <body>
                    
                </body>
                
                
               
                <script src="<?=base_url()?>/js/script.js"></script>
                <script>
                    
                    
                    var oui = new AlerteAlizon("Alerte",'http://localhost/Alizon/ci4/public/test');
                    oui.ajouterBouton("Confirmer",'normal-button petit-button supprimer-filtre vert');
                    oui.affichage();
                   
                    
                </script>
            <?php echo ob_get_clean();
        }

        public function test3()
        {
            $prods=model("\App\Models\ProduitPanierModel")->getPanierFromClient(1);
            model("\App\Models\ProduitPanierModel")->delete(1);
            print_r($prods);
        }
}
