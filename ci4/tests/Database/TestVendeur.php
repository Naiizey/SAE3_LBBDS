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

        
        
        for($i=0;$i<5;++$i){
            $fabricatorCli = new Fabricator(Vendeur::class,array(
                "nom" => 'firstName',
                "identifiant" => "userName",
                "motdepasse" => "password"
                
            ));

            $vendeur=$fabricatorCli->make();
            $vendeur->cryptMotDePasse();
            $model_Vend->saveVendeur($vendeur);
            
        

           
        }
        
        //FIXME: Test ne verifie pas correctement car on est dans un cas de panier vide
        $this->assertCount(Fabricator::getCount($model_Vend->table), $model_Vend->findAll());
    }
}