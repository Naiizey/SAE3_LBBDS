<?php


use App\Models\Client;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\Fabricator;
use Tests\Support\Database\Seeds\ExampleSeeder;
use Tests\Support\Models\AdresseLivraisonTest;


/**
 * @internal
 */
final class ExampleDatabaseTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $seed = ExampleSeeder::class;

    /*

    public function testModelFindAll()
    {
        $model = new ExampleModel();

        // Get every row created by ExampleSeeder
        $objects = $model->findAll();
        $fabricator = new Fabricator(Client::class,array(
            "nom" => 'firstName',
            "prenom" => 'name',
            "email" => 'email',
            "identifiant" => "userName",
            "motdepasse" => "password"
            
        ));
    
        d($fabricator->make());
      

        // Make sure the count is as expected
        $this->assertCount(3, $objects);
    }
    

    public function testSoftDeleteLeavesRow()
    {
        $model = new ExampleModel();
        $this->setPrivateProperty($model, 'useSoftDeletes', true);
        $this->setPrivateProperty($model, 'tempUseSoftDeletes', true);

        $object = $model->first();
        $model->delete($object->id);

        // The model should no longer find it
        $this->assertNull($model->find($object->id));

        // ... but it should still be in the database
        $result = $model->builder()->where('id', $object->id)->get()->getResult();

        $this->assertCount(1, $result);
    }
    */

    public function testModelAdresse(){ 
        $model=model("\App\Models\AdresseLivraison");
      
        Fabricator::setCount($model->table,sizeof($model->findAll()));

        $fabricator = new Fabricator(AdresseLivraisonTest::class,null,'fr_FR');
        $ok = $fabricator->make();
        
        d($ok);
        Fabricator::upCount($model->table);
        model("\App\Models\AdresseLivraison")->save($ok);
        

        $this->assertCount(Fabricator::getCount($model->table), $model->findAll());

    }

    public function testCommande(){
        $model_C=model("\App\Models\LstCommandesCli");
        $model_A=model("\App\Models\AdresseLivraison");
        
        
        for($i=0;$i<5;++$i){
            $fabricatorCli = new Fabricator(Client::class,array(
                "nom" => 'firstName',
                "prenom" => 'name',
                "email" => 'email',
                "identifiant" => "userName",
                "motdepasse" => "password"
                
            ));

            $client=$fabricatorCli->create();

            $fabricatorAdr = new Fabricator(AdresseLivraisonTest::class,null,'fr_FR');
            $ok = $fabricatorAdr->make();
            $id_a=$model_A->enregAdresse($ok);
            
            d($client);
            $model_C->creerCommande($client->numero,$id_a);
        }
        

        $this->assertCount(Fabricator::getCount($model_C->table), $model_C->findAll());

    }
}
