<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('dashboard', 'DashboardController::index');
$routes->get('contadores', 'ContadorController::index');
$routes->get('contadores/nuevo', 'ContadorController::create');
$routes->post('contadores/guardar', 'ContadorController::store');
$routes->get('contadores/editar/(:num)', 'ContadorController::edit/$1');
$routes->post('contadores/actualizar/(:num)', 'ContadorController::update/$1');
$routes->post('contadores/eliminar/(:num)', 'ContadorController::delete/$1');
$routes->get('contadores/desactivados', 'ContadorController::desactivados');
$routes->post('contadores/reactivar/(:num)', 'ContadorController::reactivar/$1');
$routes->get('clientes', 'ClienteController::index');
$routes->get('clientes/nuevo', 'ClienteController::create');
$routes->post('clientes/guardar', 'ClienteController::store');
$routes->get('clientes/editar/(:num)', 'ClienteController::edit/$1');
$routes->post('clientes/actualizar/(:num)', 'ClienteController::update/$1');
$routes->post('clientes/eliminar/(:num)', 'ClienteController::delete/$1');
$routes->get('clientes/desactivados', 'ClienteController::desactivados');
$routes->post('clientes/reactivar/(:num)', 'ClienteController::reactivar/$1');
