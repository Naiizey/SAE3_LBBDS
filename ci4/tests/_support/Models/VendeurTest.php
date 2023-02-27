<?php

namespace Tests\Support\Models;

use App\Models\Vendeur;

class VendeurTest extends Vendeur
{
    
    public function fake(\Faker\Generator &$fake){
        $fake->addProvider(new \Faker\Provider\Tva_intercomm($fake));
        
        
        return array(
            "identifiant" => $fake->company(),
            "email" => $fake->email(),
            "motdepasse" => $fake->password(),
            "texte_presentation" => $fake->text(),
            "numero_rue" => $fake->randomNumber(2),
            "nom_rue" => $fake->streetName,
            "code_postal" => $fake->randomNumber(5),
            "ville" => $fake->city,
            "logo" => $fake->url(),
            "numero_siret" => $fake->siret(),  
            "tva_intercommunautaire" => $fake->getTva()       



            
            
        );
    }




   
}