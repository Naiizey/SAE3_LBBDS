<?php

namespace App\Models;

use App\Entities\Commande;
use \App\Entities\CommandeCli as CommandeCli;
use App\Models\Commande as ModelsCommande;
use App\Services\SessionLBBDP;
use CodeIgniter\Model;
use Exception;

/**
 * Acccès aux commandes réliées à leurs clients
 * 
 *  Données:
 *      * commande: **CR**-- 
 *      * client: -**R**-- 
 */
class LstCommandesCli extends ModelsCommande
{
    protected $table      = 'sae3.commande_list_client';
    protected $allowedFields = ['num_commande','num_compte','date_commande','date_expedition','date_arriv','prix_ht','prix_ttc','etat', 'montant_reduction', 'pourcentage_reduction'];
    protected $returnType     = CommandeCli::class;
    
    protected $primaryKey = 'num_commande';
    
    public function getCompteCommandes() : array
    { 
        (new ModelsCommande())->majCommandes();
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

     
        $this->livreurs->nouvelleCommande(new Commande(array(
            "identifiant"=>$numCommande,
            "time"=>0,
            "etat" => "En charge"
        )));
    
    }

    public function getCommandeById($num_commande){
        (new ModelsCommande())->majCommandes();
        return $this->where('num_commande',$num_commande)->findAll();
    }


}