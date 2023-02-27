<?php
namespace Faker\Provider;

class Tva_intercomm extends \Faker\Provider\Base
{
    public function getTva(){
        $siren=$this->generator->siren();
        $number=$this->generator->randomNumber(2);
        return "FR".$number.$siren;

    }
}