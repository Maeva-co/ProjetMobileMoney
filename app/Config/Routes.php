<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'admin/DashboardController::index');
});