<?php

namespace Config;

use App\Controllers\client\UsersController;
use App\Controllers\client\SoldeController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [UsersController::class, 'index']);

$routes->post('/login', [UsersController::class, 'login']);
$routes->get('/logout', [UsersController::class, 'logout']);

$routes->get('/client/solde', [SoldeController::class, 'index']);

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'admin\DashboardController::index');
});