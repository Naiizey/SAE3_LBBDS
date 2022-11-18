<?php namespace App\Controllers;

class EspaceClient extends BaseController
{
    public function index()
    {
        $data['controller'] = "EspaceClient";
        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelClient = model("\App\Models\Client");
        $post=$this->request->getPost();

        if (!empty($post))
        {
            if (!($post['pseudo'] === $modelClient->getClientPseudoById(session()->get("numero"))))
            {
                $modelClient->setClientPseudoById(session()->get("numero"), $post['pseudo']);
            }
        }

        //Pré-remplit les champs avec les données de la base
        $data['pseudo'] = $modelClient->getClientPseudoById(session()->get("numero"));
        $data['surname'] = $modelClient->getClientSurnameById(session()->get("numero"));
        $data['firstname'] = $modelClient->getClientFirstnameById(session()->get("numero"));
        $data['email'] = $modelClient->getClientMailById(session()->get("numero"));
        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numero"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numero"));

        return view('/page_accueil/espaceClient',$data);
    }
}