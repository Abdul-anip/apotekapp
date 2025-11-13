<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/obat', 'Obat::index');
$routes->get('/obat/create', 'Obat::create');
$routes->post('/obat/store', 'Obat::store');
$routes->get('/obat/edit/(:num)', 'Obat::edit/$1');
$routes->post('/obat/update/(:num)', 'Obat::update/$1');
$routes->get('/obat/delete/(:num)', 'Obat::delete/$1');

$routes->get('/penjualan', 'Penjualan::index');
$routes->get('/penjualan/add/(:num)', 'Penjualan::add/$1');
$routes->get('/penjualan/checkout', 'Penjualan::checkout');



$routes->get('/laporan', 'Laporan::index');
$routes->get('/laporan/detail/(:num)', 'Laporan::detail/$1');

$routes->get('/kategori', 'Kategori::index');
$routes->get('/kategori/create', 'Kategori::create');
$routes->post('/kategori/store', 'Kategori::store');
$routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('/kategori/delete/(:num)', 'Kategori::delete/$1');

$routes->get('/transaksi', 'Transaksi::index'); // tampilkan halaman transaksi
$routes->post('/transaksi/store', 'Transaksi::store'); // simpan transaksi ke database
$routes->get('/transaksi/remove/(:num)', 'Transaksi::remove/$1');
$routes->post('/transaksi/updateQuantity', 'Transaksi::updateQuantity');
$routes->post('/transaksi/proses', 'Transaksi::proses');
$routes->post('/transaksi/hitungKembalian', 'Transaksi::hitungKembalian');


