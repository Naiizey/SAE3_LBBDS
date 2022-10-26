<?php namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authentification implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service("App\Services\Athentification");
        if($auth->connection($this->request->getPost())){
            return redirect()->to("/connexion/401");
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
