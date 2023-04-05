<?php

namespace App\Models;

use App\Entities\Adresse;
use CodeIgniter\Model;
use Generator;

/**
 * Utile pour accéder aux adresses de livraison de manière globale
 *  Données:
 *      * adresse: -**R**-- 
 */
class AdresseLivraison extends Model
{
    protected $table      = 'sae3.adresse_livraison';
    protected $primaryKey = 'id_a';

    protected $useAutoIncrement = true;

    protected $returnType     = \App\Entities\Adresse::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ["nom", "prenom", "numero_rue","nom_rue", "code_postal", "ville", "comp_a1", "comp_a2", "infos_comp"];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    //Variable à utilser avec un Validator
    public $rules = [
        "nom" => ['rules' => "required|max_length[50]", 'errors' => array('required' => "Champs vide", "max_length" => "Maximum de caractère atteint")],
        "prenom" => ['rules' => "required|max_length[50]", 'errors' => array('required' => "Champs vide","max_length" => "Maximum de caractère atteint")],
        "numero_rue" => ['rules' => "required", 'errors' => array('required' => "Champs vide")],
        "nom_rue" => ['rules' => "required", 'errors' => array('required' => "Champs vide")],
        "code_postal" => ['rules' => "required|integer|min_length[5]|max_length[5]", 'errors' => array('required' => "Champs vide","min_length" => "Format","max_length" => "Format")], 
        "ville" => ['rules' => "required", 'errors' => array('required' => "Champs vide")],
        "comp_a1" =>  ['rules' => "max_length[150]", 'errors' => array('max_length' => "Information complémentaire trop longue, pas plus de {param}")], 
        "comp_a2" =>  ['rules' => "max_length[150]", 'errors' => array('max_length' => "Information complémentaire trop longue, pas plus de {param}")], 
        "infos_comp" => ['rules' => "max_length[250]", 'errors' => array('max_length' => "Information complémentaire trop longue, pas plus de {param} pour cette entrée")]
            
    ];


    public function enregAdresse(Adresse $adresse){
        $this->save($adresse);  
        return $this->insertID;
    }

    public function getAdresseById($id){
        return $this->find($id);
    }
   
    public function getByCommande($numCommande){
   
        $retour = $this->where('num_commande',$numCommande)->findAll();
        if(empty($retour)){
            return null;
        }
        return $retour[0];
    }  




   
}