<?php

namespace App\Models;

use CodeIgniter\Model;
use Generator;

/** 
 * Model de classe client qui permet de récuperer un client, ainsi qu'insérer et mettre à jour.
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Client
 */
class AdresseLivraison extends Model
{
    protected $table      = 'sae3.adresse_livraison';
    protected $primaryKey = 'numero';

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


   




   
}