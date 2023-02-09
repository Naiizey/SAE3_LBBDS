<?php

namespace Tests\Support\Models;

use App\Models\Vendeur;

class VendeurTest extends Vendeur
{
    
    public function fake(\Faker\Generator &$fake){
        $faker = new \Faker\Generator();
        //$faker->addProvider(new Faker\Provider\en_US\Address($faker));
        $faker->addProvider(new Faker\Provider\Lorem($faker));
        $faker->addProvider(new Faker\Provider\en_US\Company($faker));
        
        return array(
           
            "numero_rue" => $faker->randomNumber(2),
            "nom_rue" => $fake->streetName,
            "code_postal" => $faker->randomNumber(5),
            "ville" => $fake->city
            
            
        );
    }




   
}