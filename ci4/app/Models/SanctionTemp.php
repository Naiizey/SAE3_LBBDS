<?php

namespace App\Models;

use \App\Entities\SanctionTempo as SanctionTempo;
use CodeIgniter\Model;
use Exception;
use CodeIgniter\I18n\Time;

class SanctionTemp extends Model
{
    protected $table      = 'sae3.sanction_temporaire';
    protected $primaryKey = 'id_sanction';

    protected $useAutoIncrement = true;

    protected $returnType     = SanctionTempo::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id_sanction','raison','num_compte','date_debut','heure_debut','date_fin','heure_fin'];

    public function ajouterSanction($raison, $numCompte, $dureeJours)
    {
        $sanction=new SanctionTempo();
        $sanction->raison=$raison;
        $sanction->num_compte=$numCompte;
        $sanction->date_debut=Time::now("Europe/Paris",'fr-FR')->toDateString();
        $sanction->heure_debut=Time::now("Europe/Paris",'fr-FR')->toTimeString();
        $fin=Time::now("Europe/Paris",'fr-FR')->addDays($dureeJours);
        $sanction->date_fin=$fin->toDateString();
        $sanction->heure_fin=$fin->toTimeString();
        $this->save($sanction);
    }

    public function supprimerSanctionsExpirées(){
        $this->where('date_fin <',Time::now("Europe/Paris",'fr-FR')->toDateString())->orWhere('date_fin',Time::now("Europe/Paris",'fr-FR')->toDateString())->where('heure_fin <',Time::now("Europe/Paris",'fr-FR')->toTimeString())->delete();
    }

    public function TimeoutsActuels(){
        $this->supprimerSanctionsExpirées();
        
        // return every sanctions that are not expired today or in the future
        return $this->where('date_fin',Time::now("Europe/Paris",'fr-FR')->toDateString())->where('heure_fin >',Time::now("Europe/Paris",'fr-FR')->toTimeString())->orWhere('date_fin >',Time::now("Europe/Paris",'fr-FR')->toDateString())->findAll();
    }

    public function isTimeout($numCompte){
        $this->supprimerSanctionsExpirées();
        
        return ($this->where('num_compte',strval($numCompte))->countAllResults()) > 0;
    }

    // fonction qui renvoie le temps restant avant la fin du timeout, soit en secondes, soit en minutes, soit en heures, soit en jours, soit en années
    public function getTimeLeft($numCompte){
        $this->supprimerSanctionsExpirées();
        $sanction=$this->where('num_compte',strval($numCompte))->where('date_fin >=',Time::now("Europe/Paris",'fr-FR')->toDateString())->where('heure_fin >',Time::now("Europe/Paris",'fr-FR')->toTimeString())->orWhere('date_fin >',Time::now("Europe/Paris",'fr-FR')->toDateString())->first();
        if($sanction==null){
            return 0;
        }
        $fin=Time::createFromFormat('Y-m-d H:i:s',$sanction->date_fin.' '.$sanction->heure_fin,"Europe/Paris");
        $tempsRestant=$fin->getTimestamp()-Time::now("Europe/Paris",'fr-FR')->getTimestamp();
        if($tempsRestant<60){
            return $tempsRestant.' seconde.s';
        }
        if($tempsRestant<3600){
            return floor($tempsRestant/60).' minute.s';
        }
        if($tempsRestant<86400){
            return floor($tempsRestant/3600).' heure.s';
        }
        if($tempsRestant<31536000){
            return floor($tempsRestant/86400).' jour.s';
        }
        return floor($tempsRestant/31536000).' an.s';
    }
    
}