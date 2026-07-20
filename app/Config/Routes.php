<?php

namespace Config;

use App\Controllers\client\UsersController;
use App\Controllers\client\SoldeController;
use App\Controllers\client\DepotController;
use App\Controllers\client\RetraitController;
use App\Controllers\client\TransfertController;
use App\Controllers\client\HistoriqueController;


/**
 * @var RouteCollection $routes
 */
$routes->get('/', [UsersController::class, 'index']);

$routes->post('/login', [UsersController::class, 'login']);
$routes->get('/logout', [UsersController::class, 'logout']);

$routes->get('/client/solde', [SoldeController::class, 'index']);
$routes->get('/client/depot', [DepotController::class, 'index']);
$routes->post('/client/depot', [DepotController::class, 'store']);
$routes->get('/client/retrait', [RetraitController::class, 'index']);
$routes->post('/client/retrait', [RetraitController::class, 'store']);
$routes->get('/client/transfert', [TransfertController::class, 'index']);
$routes->post('/client/transfert', [TransfertController::class, 'store']);
$routes->get('/client/historiques', [HistoriqueController::class, 'index']);





$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'admin\DashboardController::index');
});