<?php namespace App\Services;

use ErrorException;
use Exception;
use Socket;

abstract class SocketConnect{
    protected $service_port = 8082;
    protected $address;
    protected $socket;


    public function __construct(){
        $this->address=gethostbyname('localhost');
       
    
    }

    private function connexion(){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option( $this->socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>0));
        log_message('debug', "Connexion TCP/IP");
        if ($this->socket === false) {
            throw new SocketError("socket_create() a échoué : raison :  " . socket_strerror(socket_last_error()) . "\n");
        } else {
            log_message('debug', "OK.\n");
        }
        log_message('debug', "Essai de connexion à '$this->address' sur le port '$this->service_port'...");
        $result = socket_connect($this->socket, $this->address, $this->service_port);
        if ($this->socket === false) {
            throw new SocketError("socket_connect() a échoué : raison : ($result) " . socket_strerror(socket_last_error()) . "\n");
        } else {
            log_message('debug', "OK.\n");
        }
    }


    abstract protected function fermeture();

    private function deconnexion(){
        log_message('debug', "Fermeture du socket...");
        socket_close($this->socket);
        log_message('debug', "OK.\n\n");
    }

    protected function dialogueSimple($req){
        $this->connexion();
        log_message('debug', $req);
        log_message('debug', "Envoi de la requête HTTP HEAD...");
        socket_write($this->socket, $req, strlen($req));
        log_message('debug', "OK.\n");
        
        log_message('debug', "Lire la réponse : \n\n");
        if ($rep = socket_read($this->socket, 4048)) {}
        $this->fermeture();
        $this->deconnexion();

        return $rep;
    }

    protected function dialogueSimpleRepLongue($req,$until){
        $this->connexion();
        log_message('debug', $req);
        log_message('debug', "Envoi de la requête HTTP HEAD...");
        socket_write($this->socket, $req, strlen($req));
        log_message('debug', "OK.\n");
        
        log_message('debug', "Lire la réponse : \n\n");
    
        $rep="";
        while(!str_contains($rep,$until)  && $rep .= socket_read($this->socket, 4048) ) {}
        $this->fermeture();
        $this->deconnexion();

        return $rep;
    }

}

class SocketError extends Exception{

    public function __construct($message){
        parent::__construct($message,500);
    }

}

