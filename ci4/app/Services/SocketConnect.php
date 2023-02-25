<?php namespace App\Services;


class SocketConnect{
    public $service_port = 8080;
    public $address;
    public $socket;


    public function __construct(){
        $this->address=gethostbyname('localhost');
        d("Connexion TCP/IP");

        
        
        
        /* Crée un socket TCP/IP. */
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($this->socket === false) {
            d("socket_create() a échoué : raison :  " . socket_strerror(socket_last_error()) . "\n");
        } else {
            d("OK.\n");
        }
        
        echo "Essai de connexion à '$this->address' sur le port '$this->service_port'...";
        $result = socket_connect($this->socket, $this->address, $this->service_port);
        if ($this->socket === false) {
            d("socket_connect() a échoué : raison : ($result) " . socket_strerror(socket_last_error()) . "\n");
        } else {
            d("OK.\n");
        }
        
        $auth = array("auth" => array('id' => '153', 'pass'=> "39715c8f486b05c362dd45fd2872dc03"));
        
        $in = "AUT LBBDP/1.0\r\n ";
        $in .= json_encode($auth);
        //$in .= '{{ "auth": { "id" : "153", "pass" : "39715c8f486b05c362dd45fd2872dc03" } }}'."\r\n;\r\n";
        $in .= " \r\n;\r\n";
        $out = '';
        //echo $in;
        d("Envoi de la requête HTTP HEAD...");
        socket_write($this->socket, $in, strlen($in));
        d("OK.\n");
        
        d("Lire la réponse : \n\n");
        while ($out = socket_read($this->socket, 4048)) {
            echo $out;
        }
        
        d("Fermeture du socket...");
        socket_close($this->socket);
        d("OK.\n\n");
    }
}