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
    public function connexion($entree) : array
    {   
        $errors=[];
        if(!empty($entree))
        {
            $clientModel = model("\App\Models\Client");
            $user = $clientModel->getClientByPseudo($entree -> identifiant,$entree -> motDePasse,false);
            
            if($user == null) 
            {
                $user = $clientModel->getClientByEmail($entree -> identifiant,$entree -> motDePasse,false);
            }
            if($user == null)
            {
                //Impossible de trouver un utilisateur avec son identifiant (pseudo) ou son email
                $errors[1] = "Connexion refusée, identifiant et ou mot de passe incorrects";
            }
        }
        else
        {
            $errors[0] = "Pas d'entrée";
        }

        if (empty($errors))
        {
            $session = session();
            $session->set('numero',$user->numero);
            $session->set('identifiant',$user->identifiant);
            $session->set('motDePasse',$user->motDePasse);
        }

        return $errors;
    }

    public function inscription(\App\Entities\Client $entree, $verifMdp) : array
    {   
        $errors=[];
        if(!empty($entree))
        {
            if(empty($entree->motDePasse) || empty($entree->pseudo) || empty($entree->nom) || empty($entree->prenom) || empty($entree->email)) 
            {
                $errors[1]="Remplissez le(s) champs vide(s)";
            }
            if(strlen($entree->nom) > 50 && strlen($entree->prenom) > 50)
            {
                $errors[2]= "50 caractères maximum pour le nom (" . strlen($entree->prenom) . " actuellement) et/ou prénom (" . strlen($entree->nom) . " actuellement)";
            } 
            if(strlen($entree->pseudo) > 30 )
            {
                $errors[3]="30 caractères maximum pour le pseudo (" .strlen($entree->pseudo) . " actuellement)";
            }
            if(!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) && strlen($entree->email)<255) 
            {
                $errors[4]="255 caractères maximum pour l'email et caractère spéciaux interdits";
            }
            if (preg_match_all("/[a-z]/",$entree->motDePasse) < 1 ||  preg_match_all("/[A-Z]/",$entree->motDePasse) < 1 ||  preg_match_all("/[0-9]/",$entree->motDePasse) < 1 ||  strlen($entree->motDePasse) < 12)
            {
                #TODO: Doit on autoriser les caractères spéciaux ou non dans le mot de passe?
                //||  preg_match_all("/\W/",$entree->motDePasse) < 1

                $errors[5]="Le mot de passe doit faire plus de 12 caractère et doit contenir au moins une majuscule, une minuscule et un chiffre";
            }
            if($entree->motDePasse != $verifMdp) 
            {
                $errors[6]="Les mots de passes ne correspondent pas";
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }
        
        if(empty($errors))
        {
            $compteModel=model("\App\Models\Client");
            $entree->cryptMotDePasse();

            if ($compteModel->doesClientExists($entree->pseudo))
            {
                $errors[9]="Un utilisateur existe déjà avec ce pseudo";
            }
            /*if ($compteModel->getClientByCredentials($entree->pseudo,$entree->motDePasse,true) != null)
            {
                $errors[7]="Vous êtes déjà inscrit";
            }*/
            /*if ($compteModel->getClientByEmail($entree->email,$entree->motDePasse,true) != null)
            {
                $errors[8]="Un utilisateur existe déjà avec cette adresse mail";
            }*/
            /*if ($compteModel->getClientByPseudo($entree->pseudo,$entree->motDePasse,true) != null)
            {
                $errors[9]="Un utilisateur existe déjà avec ce pseudo";
            }*/
            if (empty($errors))
            {
                $compteModel->save($entree);
                $session = session();
                $user=$compteModel->where("email",$entree->email)->findAll()[0];
                $session->set('numero',$user->numero);
                $session->set('identifiant',$user->identifiant);
                $session->set('motDePasse',$user->motDePasse);
            }
        }

        return $errors;
    }

    public function estConnectee() : bool
    {   
        $session = session();
        if($session->has('numero')){
            $clientModel = model("\App\Models\Client");
            if($clientModel->getClientByCredentials($session->get('identifiant'),$session->get('motDePasse'),true) != null)
            {
                return true;
            }
            else return false;
        }
        else return false;
    }
    #TODO: chargement des produit panier visiteur dans panier client
}
