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

    // prefixe operateurs
    $routes->get('operators', 'admin\OperatorsController::index');
    $routes->get('operators/create', 'admin\OperatorsController::create');
    $routes->post('operators/store', 'admin\OperatorsController::store');
    $routes->get('operators/edit/(:num)', 'admin\OperatorsController::edit/$1');
    $routes->post('operators/update/(:num)', 'admin\OperatorsController::update/$1');
    $routes->get('operators/delete/(:num)', 'admin\OperatorsController::delete/$1');

    // types de transactions
    $routes->get('transaction-types', 'admin\TransactionTypesController::index');
    $routes->get('transaction-types/create', 'admin\TransactionTypesController::create');
    $routes->post('transaction-types/store', 'admin\TransactionTypesController::store');
    $routes->get('transaction-types/edit/(:num)', 'admin\TransactionTypesController::edit/$1');
    $routes->post('transaction-types/update/(:num)', 'admin\TransactionTypesController::update/$1');
    $routes->post('transaction-types/update/transfert', 'admin\TransactionTypesController::updateTransfert');
    $routes->get('transaction-types/delete/(:num)', 'admin\TransactionTypesController::delete/$1');

    // configuration frais
    $routes->get('config', 'admin\ConfigController::index');
    $routes->get('config/create', 'admin\ConfigController::create');
    $routes->post('config/store', 'admin\ConfigController::store');
    $routes->get('config/edit/(:num)', 'admin\ConfigController::edit/$1');
    $routes->post('config/update/(:num)', 'admin\ConfigController::update/$1');
    $routes->get('config/delete/(:num)', 'admin\ConfigController::delete/$1');
    $routes->get('config/history', 'admin\ConfigController::history');

    // gains
    $routes->get('gains', 'admin\GainsController::index');

    // clients
    $routes->get('clients', 'admin\ClientsController::index');
    $routes->get('clients/(:num)', 'admin\ClientsController::show/$1');
});
