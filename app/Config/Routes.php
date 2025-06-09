<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

// Authentication routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::authenticate');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::create');

// Client routes
$routes->group('clients', function($routes) {
    $routes->get('/', 'Clients::index');
    $routes->get('create', 'Clients::create');
    $routes->post('store', 'Clients::store');
    $routes->get('edit/(:num)', 'Clients::edit/$1');
    $routes->post('update/(:num)', 'Clients::update/$1');
    $routes->get('view/(:num)', 'Clients::view/$1');
    $routes->delete('delete/(:num)', 'Clients::delete/$1');
});

// Job routes
$routes->group('jobs', function($routes) {
    $routes->get('/', 'Jobs::index');
    $routes->get('create', 'Jobs::create');
    $routes->post('store', 'Jobs::store');
    $routes->get('edit/(:num)', 'Jobs::edit/$1');
    $routes->post('update/(:num)', 'Jobs::update/$1');
    $routes->get('view/(:num)', 'Jobs::view/$1');
    $routes->delete('delete/(:num)', 'Jobs::delete/$1');
    $routes->post('update-status/(:num)', 'Jobs::updateStatus/$1');
});

// Schedule routes
$routes->group('schedule', function($routes) {
    $routes->get('/', 'Schedule::index');
    $routes->get('calendar', 'Schedule::calendar');
    $routes->get('api/events', 'Schedule::getEvents');
});

// Invoice routes
$routes->group('invoices', function($routes) {
    $routes->get('/', 'Invoices::index');
    $routes->get('create', 'Invoices::create');
    $routes->post('store', 'Invoices::store');
    $routes->get('edit/(:num)', 'Invoices::edit/$1');
    $routes->post('update/(:num)', 'Invoices::update/$1');
    $routes->get('view/(:num)', 'Invoices::view/$1');
    $routes->get('pdf/(:num)', 'Invoices::generatePDF/$1');
    $routes->post('send/(:num)', 'Invoices::sendInvoice/$1');
    $routes->delete('delete/(:num)', 'Invoices::delete/$1');
});

// Payment routes
$routes->group('payments', function($routes) {
    $routes->get('/', 'Payments::index');
    $routes->post('process', 'Payments::process');
    $routes->get('success', 'Payments::success');
    $routes->get('cancel', 'Payments::cancel');
});

// API routes for mobile/offline sync
$routes->group('api', function($routes) {
    $routes->get('sync', 'Api::sync');
    $routes->post('sync', 'Api::syncData');
    $routes->get('jobs', 'Api::getJobs');
    $routes->post('jobs', 'Api::createJob');
    $routes->put('jobs/(:num)', 'Api::updateJob/$1');
});