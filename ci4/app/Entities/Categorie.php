<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Categorie extends Entity{

    private $sousCatModel;

    public $datamap = [
        "codeCat" => "code_cat"
    ];
    
    public function __construct()
    {
        parent::__construct();
        $this->sousCatModel=model("App\Models\SousCategorieModel");
    }


    public function getAllSousCat(){
        return $this->sousCatModel->where("code_sur_cat",$this->codeCat)->findAll();
    }
}