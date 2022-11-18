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

            /*
            Pas comme ça, 
            1: Au tout début, utilise la fonction getClienById du Model qui va de retourner une entité Client 
            2: À chaque modif, modifie la propriété de l'entité sans faire appel au Model
            3: Si il faut save appel ta méthode save dans laquelle tu prend en paramètre l'entité client
            4: Utilise aussi cette entité pour mettre des valeurs dans data
            Bref, moins d'appel au model, juste 2 fois: créer l'entité et pour la sauvegarde
            */
            $besoinDeSave = false;
            if (isset($post['pseudo']))
            {
                if (!($post['pseudo'] === $modelClient->getClientPseudoById(session()->get("numero"))))
                {
                    $modelClient->setClientPseudoById(session()->get("numero"), $post['pseudo']);
                    $besoinDeSave = true;
                }
            }
            if (isset($post['prenom']))
            {
                if (!($post['prenom'] === $modelClient->getClientPrenomById(session()->get("numero"))))
                {
                    $modelClient->setClientPrenomById(session()->get("numero"), $post['prenom']);
                    $besoinDeSave = true;
                }
            }
            if (isset($post['nom']))
            {
                if (!($post['nom'] === $modelClient->getClientNomById(session()->get("numero"))))
                {
                    $modelClient->setClientNomById(session()->get("numero"), $post['nom']);
                    $besoinDeSave = true;
                }
            }
            if (isset($post['email']))
            {
                if (!($post['email'] === $modelClient->getClientMailById(session()->get("numero"))))
                {
                    $modelClient->setClientMailById(session()->get("numero"), $post['email']);
                    $besoinDeSave = true;
                }
            }
            if ($besoinDeSave)
            {
                $modelClient->saveClient(session()->get("numero"));
            }
        }
        
        //Pré-remplit les champs avec les données de la base
        $data['pseudo'] = $modelClient->getClientPseudoById(session()->get("numero"));
        $data['prenom'] = $modelClient->getClientPrenomById(session()->get("numero"));
        $data['nom'] = $modelClient->getClientNomById(session()->get("numero"));
        $data['email'] = $modelClient->getClientMailById(session()->get("numero"));
        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numero"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numero"));

        return view('/page_accueil/espaceClient',$data);
    }
}