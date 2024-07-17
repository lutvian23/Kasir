<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/product', 'Home::product');
$routes->get('/product/data', 'productController::index');
$routes->post('/product/add', 'productController::store');
$routes->get('/product/edit/(:any)','productController::edit/$1');
$routes->put('/product/update/(:any)','productController::update/$1');
$routes->delete('/product/delete/(:any)','productController::destroy/$1');