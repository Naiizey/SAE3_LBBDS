<?php namespace App\Services;


/**
 * Service pouvant être importé de cette façon : $auth = service('authentification');
 * 
 * Ce service permet la vérification qu'un utilisateur est bienn connecté et existant dans la base, permet aussi à la connexion 
 * d'un client à partir de ses identifiants
 * //TODO: Implémetation avec token cookie ?
 */

class Authentification
{

    public function connexion($entree) : bool
    {   
        if(! empty($entree))
        {
            $clientModel = model("\App\Models\Client");
            $user = $clientModel->getClientByCredentials($entree['identifiant'],$entree['identifiant']);
           
            
            if($user==null)
            {
               
                return False;
            }
            else
            {
                $session = session();
                $session->set('identifiant',$user[0]->identifiant);
                $session->set('motDePasse',$user[0]->motDePasse);
                return True;
            }
        }
        
    }

    public function estConnectee() : bool
    {   
        $session = session();
        if($session->has('identifiant') && $session->has('motDePasse')){
            $clientModel = model("\App\Models\Client");
            if($clientModel->getClientByCredentials($session->get('identifiant'),$session->get('motDePasse')) != null)
            {
                return true;
            }
            else return false;
        }
        else return false;
        
        
    }



}
