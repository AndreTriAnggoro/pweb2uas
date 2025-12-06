<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');

$routes->get('/login', 'Auth::index');
$routes->post('/login/auth', 'Auth::loginAuth');
$routes->get('/register', 'Auth::register');
$routes->post('/auth/Register', 'Auth::registerAuth');
$routes->get('/logout', 'Auth::logout');
$routes->get('/admin/index', 'Auth::admin');

$routes->get('/build', 'Build::index');

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->post('/contact/sendMessage', 'Contact::sendMessage');
});

$routes->get('/admin/produk/', 'Admin\Produk::index');
$routes->get('/admin/produk/tambah', 'Admin\Produk::tambah');
$routes->post('/admin/produk/simpan', 'Admin\Produk::simpan');

$routes->get('/admin/produk/ubah/(:num)', 'Admin\Produk::ubah/$1');
$routes->post('/admin/produk/update/(:num)', 'Admin\Produk::update/$1');

$routes->get('/admin/produk/delete/(:num)', 'Admin\Produk::delete/$1');
$routes->get('detail/(:num)', 'Admin\Produk::detail/$1');
