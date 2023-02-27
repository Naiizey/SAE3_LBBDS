<?php

namespace App\Models;

use \App\Entities\CommandeCli as CommandeCli;
use CodeIgniter\Model;
use Exception;

class LstCommandesCli extends Model
{
    protected $table      = 'sae3.commande_list_client';
    protected $primaryKey = 'num_panier';

    protected $useAutoIncrement = false;

    protected $returnType     = CommandeCli::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_arriv','prix_ht','prix_ttc','etat', 'montant_reduction', 'pourcentage_reduction'];

    public function getCompteCommandes() : array
    { 
        return $this->where('num_compte',session()->get("numero"))->findAll();
    }

    public function creerCommande($numClient,$id_adresse_livr){

        
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do{
            $numCommande = '';
            
            for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
                $numCommande .= $characters[$index];
            }
        }while(!empty($this->db->table('sae3.insert_commande')->where("num_commande",$numCommande)->get()->getResult()));

        
        $this->db->table('sae3.insert_commande')->insert(array(
                "num_commande"=>$numCommande,
                "num_compte"=>$numClient,
                "id_a"=>$id_adresse_livr
        ));            
    }

    public function getCommandeById($num_commande){
        return $this->where('num_commande',$num_commande)->findAll();
    }
}