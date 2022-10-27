<?php namespace App\Services;

class Authentification
{

    public function connexion($entree) : bool
    {   
        if(! empty($entree))
        {
            $clientModel = model("\App\Models\Client");
            $user = new \App\Entities\Client();
            $user=$clientModel->where('identifiant',$entree['identifiant'])->where('motdepasse',$entree['motDePasse'])->findAll();
            
            if(sizeof($user)==0)
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


}
