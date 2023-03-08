<?php namespace App\Models;

use App\Entities\Commande as EntitiesCommande;
//use App\Services\LBBDPconstants;
use App\Services\SessionLBBDP;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;


interface LBBDPconstants {
    const REUSSITE = 0;
    const EXECUTION = 1;
    const EN_ATTENTE = 2;

    
    const ETAT_CHARGE=1;
    const ETAT_REGION=2;
    const ETAT_LOCAL=3;
    const ETAT_LOCAL2=4;
    const ETAT_DEST=5;

    const STRING_ETAT=array(
        self::ETAT_CHARGE => "en charge",
        self::ETAT_REGION=>"regional",
        self::ETAT_LOCAL=>"local",
        self::ETAT_LOCAL2=>"local",
        self::ETAT_DEST=>"destinataire"

    );

    const OP_INCONNUE=11;
    const AUTH_MANQUANTE=12;
    const AUTH_INCONNUE=13;
    const ERR_FILE_PLEINE=31;
    const ERR_FORMAT_JSON=41;
    const ERR_CONTENU_JSON=42;
    const ERR_INTERNE=50;

    const MESSAGES=array(
        self::OP_INCONNUE => "Opération inconnue",
        self::AUTH_MANQUANTE => "Authentification manquante",
        self::AUTH_INCONNUE => "Authentification inconnue ou erronée",
        self::ERR_FILE_PLEINE => "Pas d'autres livraison possible",
        self::ERR_FORMAT_JSON => "Erreur dans le format du JSON",
        self::ERR_CONTENU_JSON => "Erreur dans le contenu du JSON",
        self::ERR_INTERNE => "Erreur inconnue côte application livraison"

    );


}

class Commande extends Model implements LBBDPconstants
{
    protected $primaryKey = 'num_commande';

    protected $useAutoIncrement = false;

    protected $returnType     = EntitiesCommande::class;
    protected $useSoftDeletes = false;   
    
    protected $table      = 'sae3.commande';
    protected $allowedFields = ['date_commande', 'date_plateformereg', 'date_plateformeloc','date_arriv'];

    protected $livreurs;
    public function __construct(?ConnectionInterface $db = null,?ValidationInterface $validation = null)
    {
        parent::__construct($db,$validation);
        $this->livreurs=new SessionLBBDP(153,"39715c8f486b05c362dd45fd2872dc03");//service('lbbdp');
    }

    static private function verifMajDate($entity, $prop){
        if(is_null($entity->$prop)){
            $entity->$prop=date('Y-m-d H:i:s');
        } 
    }
    public function majCommandes() 
    {
        $commandes=$this->livreurs->getAndRepCommandes()["commandes"];
        foreach($commandes as $commande){
            $trouve=$this->find(strval($commande->identifiant));
            if(!is_null($trouve)){
                //$dateDepart=$trouve->dateCommande;
                switch($commande->getEtatNum()){
                    case self::ETAT_DEST:
                        self::verifMajDate($trouve,"dateArriv");
                    case self::ETAT_LOCAL:
                        self::verifMajDate($trouve,"dateLoc");
                    case self::ETAT_LOCAL2:
                        self::verifMajDate($trouve,"dateLoc");
                    case self::ETAT_REGION:
                        self::verifMajDate($trouve,"dateReg");
                        break;
                  
                }
                d($trouve);
                d($trouve->toRawArray());
        
                
                $this->update($trouve->identifiant,$trouve->toRawArray());
            }
        }
        
    }


}