<?php namespace App\Controllers;

class EspaceClient extends BaseController
{
    public function index(){
        $data['controller'] = "EspaceClient";

        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelEmail = model("\App\Models\ClientMail");
        $modelClient = model("\App\Models\Client");

        $data['pseudo'] = $modelClient->getClientPseudoById(session()->get("numero"));
        $data['surname'] = $modelClient->getClientSurnameById(session()->get("numero"));
        $data['firstname'] = $modelClient->getClientFirstnameById(session()->get("numero"));

        $data['email'] = $modelEmail->getMail(session()->get("numero"));

        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numero"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numero"));

        return view('/page_accueil/espaceClient',$data);
    }
}
