<?php namespace App\Services;

use App\Entities\Commande;
use Exception;

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

class SessionLBBDP extends SocketConnect implements LBBDPconstants{
    //'153
    //"39715c8f486b05c362dd45fd2872dc03"
    


    public function __construct($id,$pass){
        parent::__construct();
        $auth = array("auth" => array('id' => strval($id), 'pass'=> strval($pass)));
        
        $in = "AUT LBBDP/1.0\r\n ";
        $in .= json_encode($auth);
        $in .= " \r\n;\r\n";

        $out=explode(' ',$this->dialogueSimple($in))[0];
     
        if($out >= 10)
        {
            throw new LBBDPErrors($out);
        }
    }

    private static function bodyProtocole($commandes){
        return array(
            (sizeof($commandes) > 1)?"livraisons":"livraison" => $commandes
        );
    }


    protected function fermeture(){
        $req= "STP LBBDP/1.0\r\n ";
        socket_write($this->socket, $req, strlen($req));
    
    }

    public function nouvelleCommande($commandes){
        
        $in = "NEW LBBDP/1.0\r\n ";
        $in .= json_encode(self::bodyProtocole($commandes), JSON_PRETTY_PRINT);
        $in .= " \r\n;\r\n";

       

        $out=explode(' ',$this->dialogueSimple($in))[0];
        d($out);
        if($out >= 10)
        {
            throw new LBBDPErrors($out);
        }
        else
        {
            return $out;
        }

        

    }

    private function getCommandes(){
        $in = "ACT LBBDP/1.0\r\n ";
        $in .= json_encode(array(), JSON_PRETTY_PRINT);
        $in .= " \r\n;\r\n";

        $out=$this->dialogueSimpleRepLongue($in,"LBBDP/1.0");
        $json=substr($out,0,strlen($out)-21);
        $rep=explode(' ',substr($out,strlen($json),21))[0] ;//Dans un message XX LBBDP/1.0 où XX est le code réponse, on récupère uniquement le code réponse convertit en int
        $rep=intval(substr($rep,strlen($rep)-1));//Conversion en integer, le substr est nécesaire pur nettoyer un caractère invisible
        if($rep >= 10)
        {
            throw new LBBDPErrors($out);
        }
     
        $commandes = json_decode($json,true);
        $retour=[];
        d($commandes);
        foreach($commandes["livraisons"] as $commande){
              $retour[]=new Commande($commande);
        }
        
        

        return array("repCode"=>$rep,"commandes"=>$retour); 
    }

    public function repCommandes($commandesAccuseRecep){
        

        $in = "REP LBBDP/1.0\r\n ";
        $in .= json_encode(self::bodyProtocole($commandesAccuseRecep));
        $in .= " \r\n;\r\n";

        $out=explode(' ',$this->dialogueSimpleRepLongue($in,"LBBDP"))[0];
        d($out);
        if($out >= 10)
        {
            throw new LBBDPErrors($out);
        }
        else
        {
            return intval($out);
        } 
    }

    public function getAndRepCommandes() : array
    {
        $retour=$this->getCommandes();
        d($retour["repCode"]);
        if($retour["repCode"]==self::EN_ATTENTE){
            $accuseRecep=[];
            foreach($retour["commandes"] as $commande){
                d($commande);
                if($commande->etat==self::STRING_ETAT[self::ETAT_DEST]){
                    $accuseRecep[]=$commande;
                }
            
            }
            $retour["repCode"]=$this->repCommandes($accuseRecep);
        }

        return $retour;
    }




}

class LBBDPErrors extends Exception implements LBBDPconstants{
    



    public function __construct($codeLBBDP){
        if(array_key_exists($codeLBBDP, self::MESSAGES))
        {
            parent::__construct(self::MESSAGES[$codeLBBDP],500);
        }
        else
        {
            parent::__construct("Erreur inconnue",500);
        }
    }
}

