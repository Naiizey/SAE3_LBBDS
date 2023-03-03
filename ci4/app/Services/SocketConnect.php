<?php namespace App\Services;


abstract class SocketConnect{
    protected $service_port = 8083;
    protected $address;
    protected $socket;


    public function __construct(){
        $this->address=gethostbyname('localhost');
       
    
    }

    private function connection(){
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        d("Connexion TCP/IP");
        if ($this->socket === false) {
            d("socket_create() a échoué : raison :  " . socket_strerror(socket_last_error()) . "\n");
        } else {
            d("OK.\n");
        }
        d("Essai de connexion à '$this->address' sur le port '$this->service_port'...");
        $result = socket_connect($this->socket, $this->address, $this->service_port);
        if ($this->socket === false) {
            d("socket_connect() a échoué : raison : ($result) " . socket_strerror(socket_last_error()) . "\n");
        } else {
            d("OK.\n");
        }
    }


    abstract protected function fermeture();

    private function deconnection(){
        d("Fermeture du socket...");
        socket_close($this->socket);
        d("OK.\n\n");
    }

    protected function dialogueSimple($req){
        $this->connection();
        d("Envoi de la requête HTTP HEAD...");
        socket_write($this->socket, $req, strlen($req));
        d("OK.\n");
        
        d("Lire la réponse : \n\n");
        if ($rep = socket_read($this->socket, 4048)) {}
        $this->fermeture();
        $this->deconnection();

        return $rep;
    }

    protected function dialogueSimpleRepLongue($req,$until){
        $this->connection();
        d("Envoi de la requête HTTP HEAD...");
        socket_write($this->socket, $req, strlen($req));
        d("OK.\n");
        
        d("Lire la réponse : \n\n");
        $rep="";
        while($rep .= socket_read($this->socket, 4048) && !str_contains($rep,$until)) {}
        $this->fermeture();
        $this->deconnection();

        return $rep;
    }

}

