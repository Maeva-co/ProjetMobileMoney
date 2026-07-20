<?php

use CodeIgniter\Router\RouteCollection;

use App\Controllers\UsersController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [UsersController::class, 'index']);

$routes->post('/login', [UsersController::class, 'login']);
$routes->get('/logout', [LoginController::class, 'logout']);

$routes->get('/client/solde', function () {
    return "Bienvenue sur la page Solde";
});

