<?php

namespace App\Models;

use \App\Entities\SanctionTempo as SanctionTempo;
use CodeIgniter\Model;
use Exception;

class SanctionTemp extends Model
{
    protected $table      = 'sae3.sanction_temporaire';
    protected $primaryKey = 'id_sanction';

    protected $useAutoIncrement = false;

    protected $returnType     = SanctionTempo::class;
    protected $useSoftDeletes = false;

    
    protected $allowedFields = ['id_sanction','raison','num_compte','date_debut','heure_debut','date_fin','heure_fin'];

    public function ajouterSanction($raison, $numCompte, $dureeSecondes)
    {
        $sanction=new SanctionTempo();
        $sanction->raison=$raison;
        $sanction->num_compte=$numCompte;
        $sanction->date_debut=Time::now('France','fr-FR')->toDateString();
        $sanction->heure_debut=Time::now('France','fr-FR')->toTimeString();
        $fin=Time::now('France','fr-FR')->addSeconds($dureeSecondes);
        $sanction->date_fin=$fin->toDateString();
        $sanction->heure_fin=$fin->toTimeString();
        $this->save($sanction);
    }
    

}