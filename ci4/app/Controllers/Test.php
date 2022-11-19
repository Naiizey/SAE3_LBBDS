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
           
            
            ob_start();?>
                <head>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/css/style.css" />
                <style>
                    body{
                        background-color: white;
                    }
                    .alerte-validation{
                        animation-name: jmenvais;
                        animation-duration: 4s;
                        animation-direction: alternate;
                        animation-iteration-count: 2;
                        animation-timing-function: cubic-bezier(.45,1.09,.55,.99);
                        
                    }
                    @keyframes jmenvais {
                        from{
                            top: -200px;
                            opacity: 0;
                            
                        }
                       
                        50%{
                            top: 100px;
                            opacity: 1;
                        }
                        to{
                            top: 100px;
                            opacity: 1;
                        
                        }
                         
                        
                    }
                </style>
                </head>
                <div class="alerte-validation">
                    <p>
                    <span class="logo-validation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                    </span>
                    <span>
                        Vous êtes à présent connecté en tant que...
                    </span>
                    </p>
                </div>
                <script src="<?=base_url()?>/js/script.js"></script>
            <?php echo ob_get_clean();
        }

        public function test3()
        {
            $prods=model("\App\Models\ProduitPanierModel")->getPanierFromClient(1);
            model("\App\Models\ProduitPanierModel")->delete(1);
            print_r($prods);
        }
}
