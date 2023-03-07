<?php namespace App\Services;

use App\Entities\Commande;
use Exception;

class SessionLBBDP extends SocketConnect{
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

    protected function fermeture(){
        $req= "STP LBBDP/1.0\r\n ";
        socket_write($this->socket, $req, strlen($req));
    
    }

    public function nouvelleCommande($commandes){
        $bodyProtocole=(sizeof($commandes) > 1)?"livraisons":"livraison";

        $in = "NEW LBBDP/1.0\r\n ";
        $in .= json_encode(array( $bodyProtocole => $commandes), JSON_PRETTY_PRINT);
        $in .= " \r\n;\r\n";

       

        $out=explode(' ',$this->dialogueSimple($in))[0];
        if($out >= 10)
        {
            throw new LBBDPErrors($out);
        }
        else
        {
            return $out;
        }

        

    }

    public function getCommandes(){
        $in = "ACT LBBDP/1.0\r\n ";
        $in .= json_encode(array(), JSON_PRETTY_PRINT);
        $in .= " \r\n;\r\n";

        $out=$this->dialogueSimpleRepLongue($in,"LBBDP/1.0");
        $json=substr($out,0,strlen($out)-21);
        $rep=substr($out,strlen($json),21);
        
        if($out >= 10)
        {
            throw new LBBDPErrors($out);
        }
     
        $commandes = json_decode($json);
        $retour=[];
        foreach($commandes as $commande){
              $retour[]=new Commande($commande);
        }
        
        
        d($json);
        

        return array("repCode"=>$rep,"commandes"=>$commandes); 
    }

    private function repCommandes($commandes){
        

        $in = "REP LBBDP/1.0\r\n ";
        $in .= json_encode($commandes);
        $in .= " \r\n;\r\n";

        $out=explode(' ',$this->dialogueSimpleRepLongue($in,"LBBDP"))[0];
        if($out >= 10)
        {
            throw new LBBDPErrors($out);
        }
        else
        {
            return intval($out);
        } 
    }




}

class LBBDPErrors extends Exception{
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