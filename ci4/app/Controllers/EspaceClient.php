<?php namespace App\Controllers;

class EspaceClient extends BaseController
{
    public function index()
    {
        #TODO: le système ne reconnait pas si le mot de passe (Entrez votre ancien mot de passe), est le bon
        #TODO: les erreurs sur un nom ou prénom trop long ne se montrent pas, à la place on a une erreur de la base
        #TODO: de temps en temps, l'input prends le pas sur le bouton "crayon" s'il on veut rembaler la section car il n'est pas en disabled

        $data['controller'] = "EspaceClient";
        $modelFact = model("\App\Models\ClientAdresseFacturation");
        $modelLivr = model("\App\Models\ClientAdresseLivraison");
        $modelClient = model("\App\Models\Client");
        $post=$this->request->getPost();
        $client = $modelClient->getClientById(session()->get("numero"));
        $issues = [];

        //Valeurs par défaut
        $data['motDePasse'] = "motDePassemotDePasse";
        $data['confirmezMotDePasse'] = "";
        $data['nouveauMotDePasse'] = "";

        //On cache par défaut les champs supplémentaires pour modifier le mdp
        $data['classCacheDiv'] = "cacheModifMdp";
        $data['disableInput'] = "disabled";
        $data['requireInput'] = "";

        if (!empty($post))
        {
            //Ce champs ne semble pas être défini si l'utilisateur n'y touche pas, on en informe le service
            if (!isset($post['motDePasse']))
            {
                $post['motDePasse'] = "motDePassemotDePasse";
            }

            //Si ces deux champs ne sont pas remplis, cela veut dire que l'utilisateur n'a pas cherché à modifier le mdp
            if (empty($post['confirmezMotDePasse']) && empty($post['nouveauMotDePasse']))
            {
                //On remplit ces variables pour informer le service que nous n'avons pas besoin d'erreurs sur ces champs
                $post['confirmezMotDePasse'] = "";
                $post['nouveauMotDePasse'] = "";
            }
            else
            {
                //Si l'utilisateur a cherché à modifier le mdp, alors on révèle les champs
                $data['classCacheDiv'] = "";
                $data['disableInput'] = "";
                $data['requireInput'] = "required";
            }

            $auth = service('authentification');
            $user=$client;
            $user->fill($post);
            $issues=$auth->modifEspaceClient($user, $post['confirmezMotDePasse'], $post['nouveauMotDePasse']); 
            
            if (!empty($issues))
            {
                //En cas d'erreur(s), on pré-remplit les champs avec les données déjà renseignées
                $data['motDePasse'] = $post['motDePasse'];
                $data['confirmezMotDePasse'] = $post['confirmezMotDePasse'];
                $data['nouveauMotDePasse'] = $post['nouveauMotDePasse'];
            }
            else
            {
                return redirect()->to("/espaceClient");
            }
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