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
    public function connexionClient($entree) : array
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
            $session->set("numeroClient",$user->numero);
            $session->set("nomClient",$user->nom);
            $session->set("just_connectee",True);
        }

        return $errors;
    }

    public function connexionVendeur($entree) : array
    {   
        $errors=[];
        if(!empty($entree))
        {
            $vendeurModel = model("\App\Models\Vendeur");
            $user = $vendeurModel->getVendeurByPseudo($entree -> identifiant, $entree -> motDePasse);
            
            if($user == null) 
            {
                $user = $vendeurModel->getVendeurByEmail($entree -> identifiant, $entree -> motDePasse);
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
            $session->set("numeroVendeur",$user->numero);
            $session->set("identifiantVendeur",$user->identifiant);
            $session->set("just_connectee",True);
        }

        return $errors;
    }

    public function inscriptionClient(\App\Entities\Client $entree, $verifMdp) : array
    {   
        $compteModel=model("\App\Models\Client");
        $errors=[];
        
        if(!empty($entree))
        {
            if($entree->motDePasse == "" || $entree->pseudo == "" || $entree->nom == "" || $entree->prenom == "" || $entree->email == "") 
            {
                $errors[1]= "Remplissez le(s) champ(s) vide(s)";
            }
            if(strlen($entree->nom) > 50 || strlen($entree->prenom) > 50)
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
            $session->set("numeroClient",$user->numero);
            $session->set("nomClient",$user->nom);

            $session->set("just_connectee",True);
        }

        return $errors;
    }

    public function inscriptionVendeur(\App\Entities\Vendeur $entree, $verifMdp) : array
    {   
        $compteModel=model("\App\Models\Vendeur");
        $errors=[];
        
        if(!empty($entree))
        {
            if($entree->motDePasse == "" || $entree->tva_intercommunautaire == "" || $entree->texte_presentation == "" || $entree->identifiant == "" || $entree->email == "") 
            {
                $errors[1]= "Remplissez le(s) champ(s) vide(s)";
            }
            if (strlen($entree->texte_presentation) > 255)
            {
                $errors[9]="255 caractères maximum pour la présentation";
            }
            if(strlen($entree->tva_intercommunautaire) > 15) 
            {
                $errors[2]= "15 caractères maximum pour ce champ";
            }
            if (preg_match_all("/^FR[0-9]{2}[0-9]{9}$/",$entree->tva_intercommunautaire) < 1)
            {
                $errors[13]="Format de TVA intercommunautaire invalide";
            }
            if (preg_match_all("/^[0-9]{14}$/",$entree->siret) < 1)
            {
                $errors[10]="Format de siret invalide";
            }
            if (strlen($entree->identifiant) > 30 )
            {
                $errors[3]="30 caractères maximum pour l'identifiant (" .strlen($entree->identifiant) . " actuellement)";
            } 
            if (!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) || strlen($entree->email) > 255) 
            {
                $errors[4]="255 caractères maximum pour l'email et caractère spéciaux interdits";
            }
            if (preg_match_all("/[a-z]/",$entree->motDePasse) < 1 ||  preg_match_all("/[A-Z]/",$entree->motDePasse) < 1 ||  preg_match_all("/[0-9]/",$entree->motDePasse) < 1 ||  strlen($entree->motDePasse) < 12)
            {
                $errors[5]="Le mot de passe doit faire plus de 12 caractère et doit contenir au moins une majuscule, une minuscule et un chiffre";
            }
            if ($entree->motDePasse != $verifMdp) 
            {
                $errors[6]="Les mots de passes ne correspondent pas";
            }
            if ($compteModel->doesEmailExists($entree->email))
            {
                $errors[7]="Un utilisateur existe déjà avec cette adresse mail";
            }
            //TODO: vérifier si le pseudo existe déjà coté vendeur c'est sans doute différent
            if ($compteModel->doesPseudoExists($entree->identifiant))
            {
                $errors[8]="Un utilisateur existe déjà avec cet identifiant";
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }
        
        if(empty($errors))
        {
            $entree->note_vendeur = 0;
            $entree->numero_rue = 1;
            $entree->nom_rue = "Nom";
            $entree->code_postal = 22222;
            $entree->ville = "Ville";
            $entree->logo = "https://webstockreview.net/images/sample-png-images-8.png";

            $entree->cryptMotDePasse();
            $compteModel->save($entree);

            $session = session();
            $user=$compteModel->where("email",$entree->email)->findAll()[0];
            $session->set("numeroVendeur",$user->numero);
            $session->set("identifiantVendeur",$user->identifiant);
            $session->set("just_connectee",True);
        }

        return $errors;
    }

    public function modifProfilClient(\App\Entities\Client $entree, $verifMdp, $nouveauMdp) : array
    {   
        $compteModel=model("\App\Models\Client");
        $errors=[];
        if(!empty($entree))
        {
            if($entree->motDePasse == "" || $entree->pseudo == "" || $entree->nom == "" || $entree->prenom == "" || $entree->email == "") 
            {
                $errors[1]= "Remplissez le(s) champ(s) vide(s)";
            }
            if(strlen($entree->nom) > 50 || strlen($entree->prenom) > 50)
            {
                $errors[2]= "50 caractères maximum pour le nom (" . strlen($entree->prenom) . " actuellement) et/ou prénom (" . strlen($entree->nom) . " actuellement)";
            }
            if(strlen($entree->pseudo) > 30)
            {
                $errors[8]="30 caractères maximum pour le pseudo (" .strlen($entree->pseudo) . " actuellement)";
            }
            if(!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) || strlen($entree->email) > 255) 
            {
                $errors[7]="255 caractères maximum pour l'email et caractère spéciaux interdits";
            }
            if ($entree->motDePasse != "motDePassemotDePasse") 
            {
                //Le controlleur nous informe par ces valeurs que l'utilisateur a cherché à modifier le mdp, il faut donc tout vérifier
                if (!empty($verifMdp) && !empty($nouveauMdp))
                {
                    if ($verifMdp == "" || $nouveauMdp == "")
                    {
                        $errors[1]= "Remplissez le(s) champ(s) vide(s)";
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
            //Si l'utilisateur a cherché à modifier le pseudo (qu'il est différent de celui de la base de données)
            if ($compteModel->find($entree -> numero)->pseudo != $entree->pseudo)
            {
                //Alors on vérifie si un autre utilisateur n'a pas le même pseudo
                if ($compteModel->doesPseudoExists($entree->pseudo))
                {
                    $errors[12]="Un utilisateur existe déjà avec ce pseudo";
                }
            }

            //Si l'utilisateur a cherché à modifier l'email (qu'il est différent de celui de la base de données)
            if ($compteModel->find($entree -> numero)->email != $entree->email)
            {
                //Alors on vérifie si un autre utilisateur n'a pas le même email
                if ($compteModel->doesEmailExists($entree->email))
                {
                    $errors[11]="Un utilisateur existe déjà avec cette adresse mail";
                }
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }
        
        if(empty($errors))
        {
            //Si l'utilisateur a cherché à modifier le mdp, on le crypte
            if ($entree->motDePasse != "motDePassemotDePasse") 
            {
                $entree->motDePasse=$nouveauMdp;
                $entree->cryptMotDePasse();
            }
            //Sinon on le supprime pour ne pas le modifier
            else
            {
                unset($entree->motDePasse);
            }
            $compteModel->save($entree);
        }

        return $errors;
    }

    public function modifProfilVendeur(\App\Entities\Vendeur $entree, $verifMdp, $nouveauMdp) : array
    {   
        $compteModel=model("\App\Models\Vendeur");
        $errors=[];
        if(!empty($entree))
        {
            if($entree->motDePasse == "" || $entree->tva_intercommunautaire == "" || $entree->texte_presentation == "" || $entree->identifiant == "" || $entree->email == "") 
            {
                $errors[1]= "Remplissez le(s) champ(s) vide(s)";
            }
            if(strlen($entree->tva_intercommunautaire) > 15) 
            {
                $errors[2]= "15 caractères maximum pour ce champ";
            }
            if (preg_match_all("/^FR[0-9]{2}[0-9]{9}$/",$entree->tva_intercommunautaire) < 1)
            {
                $errors[13]="Format de TVA intercommunautaire invalide";
            }
            if (preg_match_all("/^[0-9]{14}$/",$entree->siret) < 1)
            {
                $errors[10]="Format de siret invalide";
            }
            if (strlen($entree->texte_presentation) > 255)
            {
                $errors[8]="255 caractères maximum pour la présentation";
            }
            if (strlen($entree->identifiant) > 30 )
            {
                $errors[9]="30 caractères maximum pour l'identifiant (" .strlen($entree->identifiant) . " actuellement)";
            }
            if(!preg_match("/^[\w\-\.]+@[\w\.\-]+\.\w+$/",$entree->email) || strlen($entree->email) > 255) 
            {
                $errors[7]="255 caractères maximum pour l'email et caractère spéciaux interdits";
            }
            if ($entree->motDePasse != "motDePassemotDePasse") 
            {
                //Le controlleur nous informe par ces valeurs que l'utilisateur a cherché à modifier le mdp, il faut donc tout vérifier
                if (!empty($verifMdp) && !empty($nouveauMdp))
                {
                    if ($verifMdp == "" || $nouveauMdp == "")
                    {
                        $errors[1]= "Remplissez le(s) champ(s) vide(s)";
                    }
                    if($compteModel->getVendeurByPseudo($entree -> pseudo, $entree -> motDePasse) == null)
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
            //Si l'utilisateur a cherché à modifier le pseudo (qu'il est différent de celui de la base de données)
            if ($compteModel->find($entree -> numero)->pseudo != $entree->pseudo)
            {
                //Alors on vérifie si un autre utilisateur n'a pas le même pseudo
                if ($compteModel->doesPseudoExists($entree->identifiant))
                {
                    $errors[12]="Un utilisateur existe déjà avec cet identifiant";
                }
            }

            //Si l'utilisateur a cherché à modifier l'email (qu'il est différent de celui de la base de données)
            if ($compteModel->find($entree -> numero)->email != $entree->email)
            {
                //Alors on vérifie si un autre utilisateur n'a pas le même email
                if ($compteModel->doesEmailExists($entree->email))
                {
                    $errors[11]="Un utilisateur existe déjà avec cette adresse mail";
                }
            }
        }
        else 
        {
            $errors[0] ="Pas d'entrée";
        }
        
        if(empty($errors))
        {
            //Si l'utilisateur a cherché à modifier le mdp, on le crypte
            if ($entree->motDePasse != "motDePassemotDePasse") 
            {
                $entree->motDePasse=$nouveauMdp;
                $entree->cryptMotDePasse();
            }
            //Sinon on le supprime pour ne pas le modifier
            else
            {
                unset($entree->motDePasse);
            }
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
                $errors[1]="Remplissez le(s) champ(s) vide(s)";
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

                //Si l'année actuelle (sur deux chiffres) est inférieure à celle renseignée OU si le mois actuel est inférieur ou égal au mois renseigné (+année actuelle égale à celle renseignée)
                if (((int) $annee) < idate("y") || ((int) $mois) <= idate("m") && ((int) $annee) == idate("y"))
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
            $chiffres = strrev($numCartePropre);

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

            //Et si la somme de nos deux additions modulo 10 n'est pas égale à 0, alors la carte est invalide
            if (($res + $chiffresRestants) % 10 != 0)
            {
                $errors[5] = "Carte invalide";
            }
        }

        return $errors;
    }
}
