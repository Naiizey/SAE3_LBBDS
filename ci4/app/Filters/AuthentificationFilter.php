<?php namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Un filter permet d'empêcher les utilisateurs d'accéder à certains url selon le context
 * Celui ci permet vérifier si l'utilisateur est connecté avant de le laisser passer ou le rediriger sur une page erreur.
 */


class AuthentificationFilter implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        helper('cookie');
        if(!session()->has("numero")){
           
            
            
            if(str_contains(parse_url(current_url(),PHP_URL_PATH),"/facture") && has_cookie("token_panier")){
                session()->set("referer_redirection",base_url()."/panier");
                
            }else{
                session()->set("referer_redirection",current_url());
            }
            
            
            
            
            return redirect()->to("/connexion");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
