<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Vérifier si l'utilisateur est connecté
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }
        
        // Vérifier le rôle si spécifié
        if (!empty($arguments)) {
            $userRole = $session->get('role');
            if (!in_array($userRole, $arguments)) {
                // Rediriger vers le bon dashboard selon le rôle
                if ($userRole == 'admin') {
                    return redirect()->to('/admin')->with('error', 'Accès non autorisé');
                } else {
                    return redirect()->to('/client')->with('error', 'Accès non autorisé');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Ne rien faire
    }
}