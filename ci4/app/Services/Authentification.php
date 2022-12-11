<?php namespace App\Services;


/**
 * Service pouvant être importé de cette façon : $auth = service('authentification');
 * 
 * Ce service permet la vérification qu'un utilisateur est bienn connecté et existant dans la base, permet aussi à la connexion 
 * d'un client à partir de ses identifiants
 * 
 */

class Authentification
{
    public function connexion($entree) : array
    {   
        $errors=[];
        if(!empty($entree))
        {
            $clientModel = model("\App\Models\Client");
            $user = $clientModel->getClientByPseudo($entree -> identifiant,$entree -> motDePasse);
            
            if($user == null) 
            {
                $user = $clientModel->getClientByEmail($entree -> identifiant,$entree -> motDePasse);
            }
            if($user == null)
            {
                //Impossible de trouver un utilisateur avec son identifiant (pseudo) ou son email
                $errors[1] = "Connexion refusée, identifiant et/ou mot de passe incorrect(s)";
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
            $session->set('nom',$user->nom);
            $session->set('identifiant',$user->identifiant);
            $session->set('motDePasse',$user->motDePasse);
            $session->set("just_connectee",True);
        }

        return $errors;
    }

    public function inscription(\App\Entities\Client $entree, $verifMdp) : array
    {   
        $compteModel=model("\App\Models\Client");
        $errors=[];
        
        if(!empty($entree))
        {
            if($entree->motDePasse == "" || $entree->pseudo == "" || $entree->nom == "" || $entree->prenom == "" || $entree->email == "") 
            {
                $errors[1]= "Remplissez le(s) champs vide(s)";
            }
            if(strlen($entree->nom) > 50 && strlen($entree->prenom) > 50)
            {
                $errors[2]= "50 caractères maximum pour le nom (" . strlen($entree->prenom) . " actuellement) et/ou prénom (" . strlen($entree->nom) . " actuellement)";
            } 
            if(strlen($entree->pseudo) > 30 )
            {
                $errors[3]="30 caractères maximum pour le pseudo (" .strlen($entree->pseudo) . " actuellement)";
            } 
            if(!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) || strlen($entree->email) > 255) 
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
            if ($compteModel->doesEmailExists($entree->email))
            {
                $errors[7]="Un utilisateur existe déjà avec cette adresse mail";
            }
            if ($compteModel->doesPseudoExists($entree->pseudo))
            {
                $errors[8]="Un utilisateur existe déjà avec ce pseudo";
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }
        
        if(empty($errors))
        {
            $entree->cryptMotDePasse();
            
            $compteModel->save($entree);
            
            $session = session();
            $user=$compteModel->where("email",$entree->email)->findAll()[0];
            $session->set('numero',$user->numero);
            $session->set('nom',$user->nom);
            

            $session->set("just_connectee",True);
        }

        return $errors;
    }

    public function modifEspaceClient(\App\Entities\Client $entree, $verifMdp, $nouveauMdp) : array
    {   
        $compteModel=model("\App\Models\Client");
        $errors=[];
        if(!empty($entree))
        {
            if($entree->motDePasse == "" || $entree->pseudo == "" || $entree->nom == "" || $entree->prenom == "" || $entree->email == "") 
            {
                $errors[1]= "Remplissez le(s) champs vide(s)";
            }
            if(strlen($entree->nom) > 50 || strlen($entree->prenom) > 50)
            {
                $errors[2]= "50 caractères maximum pour le nom (" . strlen($entree->prenom) . " actuellement) et/ou prénom (" . strlen($entree->nom) . " actuellement)";
            }
            if ($entree->motDePasse != "motDePassemotDePasse") 
            {
                //Le controlleur nous informe par ces valeurs que l'utilisateur a cherché à modifier le mdp, il faut donc tout vérifier
                if (!empty($verifMdp) && !empty($nouveauMdp))
                {
                    if ($verifMdp == "" || $nouveauMdp = "")
                    {
                        $errors[1]= "Remplissez le(s) champs vide(s)";
                    }
                    if($compteModel->getClientByPseudo($entree -> pseudo, $entree -> motDePasse) == null)
                    {
                        $errors[3]="Ceci n'est pas votre ancien mot de passe";
                    }
                    if ($entree->motDePasse == $nouveauMdp) 
                    {
                        $errors[4]="Le nouveau mot de passe doit être différent de l'ancien";
                    }
                    if (preg_match_all("/[a-z]/",$nouveauMdp) < 1 ||  
                        preg_match_all("/[A-Z]/",$nouveauMdp) < 1 ||  
                        preg_match_all("/[0-9]/",$nouveauMdp) < 1 ||  
                        strlen($nouveauMdp) < 12)
                    {
                        $errors[5]="Le mot de passe doit faire plus de 12 caractère et doit contenir au moins une majuscule, une minuscule et un chiffre";
                    }
                    if($entree->motDePasse != $verifMdp) 
                    {
                        $errors[6]="Les mots de passes ne correspondent pas";
                    }
                }   
                //Dans ce cas c'est l'admin qui a cherché à modifier le mdp
                else
                {
                    $nouveauMdp = $entree->motDePasse;
                    if (preg_match_all("/[a-z]/",$entree->motDePasse) < 1 ||  
                        preg_match_all("/[A-Z]/",$entree->motDePasse) < 1 ||  
                        preg_match_all("/[0-9]/",$entree->motDePasse) < 1 ||  
                        strlen($entree->motDePasse) < 12)
                    {
                        $errors[5]="Le mot de passe doit faire plus de 12 caractère et doit contenir au moins une majuscule, une minuscule et un chiffre";
                    }
                }
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }
        
        if(empty($errors))
        {
            $entree->motDePasse=$nouveauMdp;
            $entree->cryptMotDePasse();
            $compteModel->save($entree);
        }

        return $errors;
    }

    public function paiement($entree) : array
    {
        $errors=[];
        if(!empty($entree))
        {
            if (empty($entree['nomCB']) || empty($entree['numCB']) || empty($entree['dateExpiration']) || empty($entree['CVC']))
            {
                $errors[1]="Remplissez le(s) champs vide(s)";
            }

            //https://www.ibm.com/docs/fr/order-management-sw/9.3.0?topic=cpms-handling-credit-cards 
            $numCartePropre = str_replace(" ", "", $entree['numCB']);
            
            if (preg_match_all("/^(34|37)\d{13}$/", $numCartePropre) < 1                                //American Express
             && preg_match_all("/^(51|55)\d{14}$/", $numCartePropre) < 1                               //MasterCard
             && preg_match_all("/^4(\d{15}|\d{12})$/", $numCartePropre) < 1                           //Visa
             && preg_match_all("/^(36\d|38\d|300|301|302|303|304|305)\d{11}$/", $numCartePropre) < 1 //Diners Club et Carte Blanche
             && preg_match_all("/^6011\d{12}$/", $numCartePropre) < 1                               //Discover
             && preg_match_all("/^(2123|1800)\d{11}$/", $numCartePropre) < 1                       //JCB
             && preg_match_all("/^3\d{15}$/", $numCartePropre) < 1)                               //JCB
            {
                $errors[2]="Format de numéro de carte bancaire invalide";
            }

            if (preg_match_all("/^(0[1-9]|1[0-2])\/?[0-9]{2}$/", $entree['dateExpiration']) < 1)
            {
                $errors[3]="Format de date d'expiration invalide";
            }
            else
            {
                $annee = substr($entree['dateExpiration'], strlen($entree['dateExpiration']) - 2, strlen($entree['dateExpiration']) - 1);
                $mois = substr($entree['dateExpiration'], 0, 2);

                //Si l'année actuelle (sur deux chiffres) est inférieure à celle renseignée OU si le mois actuel est inférieur au mois renseigné (+année actuelle égale à celle renseignée)
                if (((int) $annee) < idate("y") || ((int) $mois) < idate("m") && ((int) $annee) == idate("y"))
                {
                    $errors[4]="Votre carte est expirée";
                }
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }

        if (empty($errors))
        {
            //Vérification de la validité de la carte (Algorithme de Luhn)
            //https://www.ibm.com/docs/fr/order-management-sw/9.3.0?topic=cpms-handling-credit-cards 
            //Formatage de la liste de chiffres 
            $chiffres = str_replace(" ", "", $chiffres);
            $chiffres = strrev($chiffres);

            //Sauvegarde du premier chiffre et initialisation d'une variable qui contiendra les chiffres non utilisés
            $chiffresRestants = intval($chiffres[0]);

            //On retire le dernier chiffre
            $chiffres = substr($chiffres, 1);

            //On sauvegarde le double des chiffres tirés une fois sur 2 
            //On ne peux pas les additionner directement, il nous faut les séparer s'ils sont composés de 2 chiffres
            //On additionne entre eux les chiffres non utilisés
            $chiffresUtilises = "";
            for ($i = 0; $i < strlen($chiffres); $i++)
            {
                if ($i % 2 == 0)
                {
                    $chiffresUtilises .= strval(intval($chiffres[$i])*2);
                }
                else
                {
                    $chiffresRestants += intval($chiffres[$i]);
                }
            }

            //On convertit tous les éléments de la liste en int
            $chiffresUtilises = str_split($chiffresUtilises);
            for ($i = 0; $i < count($chiffresUtilises); $i++)
            {
                $chiffresUtilises[$i] = intval($chiffresUtilises[$i]);
            }

            //On additionne tous les chiffres de la liste
            $res = array_sum($chiffresUtilises);

            //Et si la somme de nos deux additions modulo 10 est égale à 0, alors la carte est valide
            if (($res + $chiffresRestants) % 10 != 0)
            {
                $errors[5] = "Carte invalide";
            }
        }

        return $errors;
    }
}
