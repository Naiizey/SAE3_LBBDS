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
        $client = $modelClient->getClientById(session()->get("numero"));
        $issues = [];

        if (!empty($post))
        {
            $besoinDeSave = false;
            if (isset($post['pseudo']))
            {
                if (!($post['pseudo'] === $client->identifiant))
                {
                    $client->identifiant = $post['pseudo'];
                    $besoinDeSave = true;
                }
            }
            if (isset($post['prenom']))
            {
                if (!($post['prenom'] === $client->prenom))
                {
                    $client->prenom = $post['prenom'];
                    $besoinDeSave = true;
                }
            }
            if (isset($post['nom']))
            {
                if (!($post['nom'] === $client->nom))
                {
                    $client->nom = $post['nom'];
                    $besoinDeSave = true;
                }
            }
            if (isset($post['email']))
            {
                if (!($post['email'] === $client->email))
                {
                    $client->email = $post['email'];
                    $besoinDeSave = true;
                }
            }
            if ($besoinDeSave)
            {
                $modelClient->saveClient($client);
            }

            if (isset($post['confirmezMotDePasse']) && isset($post['nouveauMotDePasse']) && ($post['motDePasse'] != "motDePassemotDePasse"))
            {
                $auth = service('authentification');
                $user=$client;
                $user->fill($post);
                $issues=$auth->inscription($user, $post['confirmezMotDePasse']); 
                
                //On retire les erreurs liées au pseudo et email qui ne sont pas modifiables dans la page espaceClient
                if (!isset($issues[3]))
                {
                    unset($issues[3]);
                }
                if (!isset($issues[8]))
                {
                    unset($issues[8]);
                }
                if (!isset($issues[4]))
                {
                    unset($issues[4]);
                }
                if (!isset($issues[7]))
                {
                    unset($issues[7]);
                }
                if (!empty($issues))
                {
                    $data['motDePasse'] = $post['motDePasse'];
                    $data['confirmezMotDePasse'] = $post['confirmezMotDePasse'];
                    $data['nouveauMotDePasse'] = $post['nouveauMotDePasse'];
                }
            }

            $data['classModifMdp'] = "modifMdpOuvert";
            $data['classLienModifMdp'] = "lienModifMdp";
        }
        else
        {
            //Valeurs par défaut
            $data['motDePasse'] = "motDePassemotDePasse";
            $data['confirmezMotDePasse'] = "";
            $data['nouveauMotDePasse'] = "";
            $data['classModifMdp'] = "modifMdpFerme";
            $data['classLienModifMdp'] = "";
        }
        
        //Pré-remplit les champs avec les données de la base
        $data['pseudo'] = $client->identifiant;
        $data['prenom'] = $client->prenom;
        $data['nom'] = $client->nom;
        $data['email'] = $client->email;
        $data['adresseFact'] = $modelFact->getAdresse(session()->get("numero"));
        $data['adresseLivr'] = $modelLivr->getAdresse(session()->get("numero"));
        $data['erreurs'] = $issues;

        return view('/page_accueil/espaceClient',$data);
    }
}