<?php

namespace Config;

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

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'admin/DashboardController::index');
});