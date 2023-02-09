<?php

use \App\Models\Vendeur;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Tests\Support\Database\Seeds\ExampleSeeder;

/**
 * @internal
 */
class TestVendeur extends CIUnitTestCase{
    use DatabaseTestTrait;

    protected $seed = ExampleSeeder::class;

    public function testInsert(){
        $model_Vend=model("\App\Models\Vendeur");

        Fabricator::setCount($model_Vend->table, sizeof($model_Vend->findAll()));
        
        for($i=0;$i<5;++$i){
            $fabricatorCli = new Fabricator(Vendeur::class,array(
                "nom" => 'firstName',
                "identifiant" => "userName",
                "motdepasse" => "password",
                "email" => "email"

                
            ));

            $vendeur=$fabricatorCli->make();
            $vendeur->cryptMotDePasse();
            $model_Vend->saveVendeur($vendeur);
            Fabricator::upCount($model_Vend->table);
            
        

           
        }
        
        d($model_Vend->findAll());
        $this->assertCount(Fabricator::getCount($model_Vend->table), $model_Vend->findAll());
    }

    public function testModif(){
        $model_Vend=model("\App\Models\Vendeur");

     
        
        
        $fabricatorCli = new Fabricator(Vendeur::class,array(

            "identifiant" => "userName",
            

          
            
        ));

        $emailFab = new Fabricator(Vendeur::class,array(

            "email" => "email",
          
        )); 


        $vendeur=$fabricatorCli->make();
        $email1=$emailFab->make();
        $email2=$emailFab->make();

        $vendeur->email=$email1->email;
        $identifiant = $vendeur->identifiant;
      
        $vendeur->cryptMotDePasse();
        $model_Vend->saveVendeur($vendeur);

        d($model_Vend->findAll());

        $reLeVendeur=$model_Vend->where('identifiant', $identifiant)->findAll()[0];
        d($reLeVendeur);
        $this->assertEquals($email1->email,$reLeVendeur->email,"L'insertion pout tester la modif n'a pas fonctionné");
        $reLeVendeur->email=$email2->email;
        $model_Vend->saveVendeur($reLeVendeur);
        

        $rereLeVendeur=$model_Vend->where('identifiant', $identifiant)->findAll()[0];
       
        $this->assertEquals($email2->email, $rereLeVendeur->email,"La modification ne fonctionne pas");
    }

    
}