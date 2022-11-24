<?php namespace App\Services;


/**
 * Service pouvant être importé de cette façon : $auth = service('card');
 * 
 * Ce service permet la vérification qu'un utilisateur est bienn connecté et existant dans la base, permet aussi à la connexion 
 * d'un client à partir de ses identifiants
 * 
 */

class Authentification
{
     public function verifcard($entree) : array
    {   
        $errors=[];
        if(!empty($entree))
        {
            if(empty($entree->nomCB) || empty($entree->numCB) || empty($entree->DateExpiration) || empty($entree->CCV)) 
            {
                $errors[1]="Remplissez le(s) champs vide(s)";
            }
            // test carte bancaire (16 chifres, autorisation )
            if(strlen($entree->nomCB) > 16)
            {
                $errors[2]= "50 caractères maximum pour le nom (" . strlen($entree->nomCB) . " actuellement) ";
            } 
            if(strlen($entree->numCB) > 30 )
            {
                $errors[3]="30 caractères maximum pour le pseudo (" .strlen($entree->pseudo) . " actuellement)";
            } 
            if(!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) && strlen($entree->email)<255) 
            {
                $errors[4]="255 caractères maximum pour l'email et caractère spéciaux interdits";
            }
            if (preg_match_all("/[a-z]/",$entree->motDePasse) < 1 ||  preg_match_all("/[A-Z]/",$entree->motDePasse) < 1 ||  preg_match_all("/[0-9]/",$entree->motDePasse) < 1 ||  strlen($entree->motDePasse) < 12)
            {
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
        return $errors;
    }
}
