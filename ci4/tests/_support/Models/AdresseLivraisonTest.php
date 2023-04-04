<?php

namespace Tests\Support\Models;

use App\Models\AdresseLivraison;

/** 
 * Model de classe client qui permet de récuperer un client, ainsi qu'insérer et mettre à jour.
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Client
 */
class AdresseLivraisonTest extends AdresseLivraison
{
    
    public function fake(\Faker\Generator &$fake){
        $faker = \Faker\Factory::create();
        return array(
            "nom" => $fake->firstName,
            "prenom" => $fake->lastName,
            "numero_rue" => $faker->randomNumber(2),
            "nom_rue" => $fake->streetName,
            "code_postal" => $faker->randomNumber(5),
            "ville" => $fake->city
            
            
        );
    }




   
}