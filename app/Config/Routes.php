<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'DashboardController::index');
$routes->get('clientes', 'ClienteController::index');
$routes->get('clientes/nuevo', 'ClienteController::create');
$routes->post('clientes/guardar', 'ClienteController::store');
$routes->get('clientes/editar/(:num)', 'ClienteController::edit/$1');
$routes->post('clientes/actualizar/(:num)', 'ClienteController::update/$1');
$routes->post('clientes/eliminar/(:num)', 'ClienteController::delete/$1');
$routes->get('clientes/desactivados', 'ClienteController::desactivados');
$routes->post('clientes/reactivar/(:num)', 'ClienteController::reactivar/$1');