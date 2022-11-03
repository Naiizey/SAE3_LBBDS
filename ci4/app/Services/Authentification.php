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
           
            
            if($user==null)return False;
            else
            {
                $session = session();
                $session->set('identifiant',$user[0]->identifiant);
                $session->set('motDePasse',$user[0]->motDePasse);
                return True;
            }
        }
        else return False;
        
    }

    public function inscription(\App\Entities\Client $entree, $verifMdp) : array
    {   
        $errors=[];
        if(! empty($entree))
        {
            
            if(
                
                empty($entree->motDePasse) 
                || empty($entree->pseudo) 
                || empty($entree->nom)
                //|| empty($entree->prenom)
                || empty($entree->email)

            ) $errors[1]="Champ(s) vide";

            if(strlen($entree->nom) > 50 && strlen($entree->prenom) > 50) $errors[2]=["Trop de caracterères,nom et prénom, 50 attendues",strlen($entree->prenom),strlen($entree->nom)];

            if(strlen($entree->pseudo) > 30 ) $errors[3]=["Trop de caracterères pseudo, 30 attendues",strlen($entree->pseudo)];

            if(!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) && strlen($entree->email)<255) $errors[4]="L'email ne correspond aux normes de tailles(255) ou de caractère";

            if (preg_match_all("/[a-z]/",$entree->motDePasse) < 1 
            ||  preg_match_all("/[A-Z]/",$entree->motDePasse) < 1 
            ||  preg_match_all("/[0-9]/",$entree->motDePasse) < 1
            //||  preg_match_all("/\W/",$entree->motDePasse) < 1
            ||  strlen($entree->motDePasse) < 12
            ) $errors[5]="Le mot de passe doit faire plus de 12 caractère et doit contenir au moins une majuscule, une minuscule et un chiffre";
            
            else if($entree->motDePasse != $verifMdp) $errors[6]="Les mots de passes ne correspondent pas";


        }
        else $errors[0] ="Pas d'entrée";
        
        if(empty($errors)){
            $compteModel=model("\App\Models\Client");
            $compteModel->save($entree);
            $session = session();
            $session->set('identifiant',$entree->identifiant);
            $session->set('motDePasse',$entree->motDePasse);
        }

        return $errors;
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
