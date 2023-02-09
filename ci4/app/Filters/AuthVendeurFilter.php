<?php namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Un filter permet d'empêcher les utilisateurs d'accéder à certains url selon le context
 * Celui ci permet vérifier si l'utilisateur est connecté avant de le laisser passer ou le rediriger sur une page erreur.
 */


class AuthVendeurFilter implements FilterInterface {
    public function before(RequestInterface $request, $arguments = null)
    {
        helper('cookie');
        if (!session()->has("numero_vendeur")) {
            return redirect()->to("/vendeur/connexion");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
