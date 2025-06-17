<?php

/**
 * @var \CodeIgniter\Router\RouteCollection $routes
 */

// Home
$routes->get('/', 'HomeController::index');

// Authentication - Direct routes without ANY filters
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::register');

$routes->get('/logout', 'AuthController::logout', ['filter' => 'auth']);

// Profile (authenticated users only)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/profil', 'AuthController::profile');
    $routes->post('/profil/update', 'AuthController::updateProfile');
    $routes->post('/profil/password', 'AuthController::changePassword');
});

// Works
$routes->get('/karya/(:segment)', 'WorkController::show/$1');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/unggah', 'WorkController::create');
    $routes->post('/karya/store', 'WorkController::store');
    $routes->get('/karya/edit/(:num)', 'WorkController::edit/$1');
    $routes->post('/karya/update/(:num)', 'WorkController::update/$1');
    $routes->delete('/karya/delete/(:num)', 'WorkController::delete/$1');
    $routes->get('/karya-saya', 'WorkController::myWorks');
});

// Gallery
$routes->get('/galeri', 'GalleryController::index');
$routes->get('/galeri/filter', 'GalleryController::filter');

// Categories
$routes->get('/kategori', 'CategoryController::index');
$routes->get('/kategori/(:segment)', 'CategoryController::show/$1');

// About
$routes->get('/tentang', function() {
    // Debug info
    echo "<h1>Debug Info - Halaman Tentang</h1>";
    echo "<pre>";
    echo "Current URL: " . current_url() . "<br>";
    echo "Base URL: " . base_url() . "<br>";
    echo "Site URL: " . site_url('/tentang') . "<br>";
    echo "</pre>";
    
    return view('about/index', ['title' => 'Tentang eKarya PTI']);
});

// API Routes
$routes->group('api/v1', function($routes) {
    // Public API
    $routes->get('works', 'Api\WorkController::index');
    $routes->get('works/(:segment)', 'Api\WorkController::show/$1');
    $routes->get('categories', 'Api\CategoryController::index');
    $routes->get('home', 'Api\HomeController::index');
    
    // Authenticated API
    $routes->post('works', 'Api\WorkController::create', ['filter' => 'auth']);
    $routes->put('works/(:num)', 'Api\WorkController::update/$1', ['filter' => 'auth']);
    $routes->delete('works/(:num)', 'Api\WorkController::delete/$1', ['filter' => 'auth']);
    $routes->get('user/works', 'Api\WorkController::userWorks', ['filter' => 'auth']);
    $routes->get('user/stats', 'Api\UserController::stats', ['filter' => 'auth']);
});

// File and Media Routes
$routes->get('/writable/uploads/(:any)', 'MediaController::serve/$1');
$routes->get('/writable/uploads/thumbnails/(:any)', 'MediaController::thumbnail/$1');

// Tambahkan route baru untuk file uploads
$routes->get('uploads/(:any)', 'UploadsController::serveFile/$1');
$routes->get('uploads/thumbnails/(:any)', 'UploadsController::serveThumbnail/$1');

// Admin Routes (future implementation)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->resource('categories', ['controller' => 'Admin\CategoryController']);
    $routes->resource('works', ['controller' => 'Admin\WorkController']);
    $routes->resource('users', ['controller' => 'Admin\UserController']);
});