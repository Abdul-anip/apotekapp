<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 🔴 Auth Routes (Tanpa Filter)
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

// 🔴 Protected Routes (Harus Login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard - Semua role bisa akses
    $routes->get('/', 'Dashboard::index');
    
    // Obat - Semua role bisa akses
    $routes->get('/obat', 'Obat::index');
    $routes->get('/obat/create', 'Obat::create');
    $routes->post('/obat/store', 'Obat::store');
    $routes->get('/obat/edit/(:num)', 'Obat::edit/$1');
    $routes->post('/obat/update/(:num)', 'Obat::update/$1');
    $routes->get('/obat/delete/(:num)', 'Obat::delete/$1');
    
    // Penjualan - Semua role bisa akses
    $routes->get('/penjualan', 'Penjualan::index');
    $routes->get('/penjualan/add/(:num)', 'Penjualan::add/$1');
    $routes->get('/penjualan/checkout', 'Penjualan::checkout');
    
    // Kategori - Semua role bisa akses
    $routes->get('/kategori', 'Kategori::index');
    $routes->get('/kategori/create', 'Kategori::create');
    $routes->post('/kategori/store', 'Kategori::store');
    $routes->get('/kategori/edit/(:num)', 'Kategori::edit/$1');
    $routes->post('/kategori/update/(:num)', 'Kategori::update/$1');
    $routes->get('/kategori/delete/(:num)', 'Kategori::delete/$1');
    
    // Transaksi - Semua role bisa akses
    $routes->get('/transaksi', 'Transaksi::index');
    $routes->post('/transaksi/store', 'Transaksi::store');
    $routes->get('/transaksi/remove/(:num)', 'Transaksi::remove/$1');
    $routes->post('/transaksi/updateQuantity', 'Transaksi::updateQuantity');
    $routes->post('/transaksi/proses', 'Transaksi::proses');
    $routes->post('/transaksi/hitungKembalian', 'Transaksi::hitungKembalian');

    
    $routes->get('/laporan/cetakStruk/(:num)', 'Laporan::cetakStruk/$1');
    

    $routes->get('/konsultasi', 'Konsultasi::index');
    $routes->post('/konsultasi/proses', 'Konsultasi::proses');
    $routes->get('/konsultasi/hasil', 'Konsultasi::hasil');
    $routes->get('/konsultasi/riwayat', 'Konsultasi::riwayat');
    

    
});

//routes khusus Pemilik (Role: pemilik)
        $routes->group('', ['filter' => 'auth', 'filter' => 'role:pemilik'], function($routes) {
            // Laporan - Hanya pemilik yang bisa akses
            $routes->get('/laporan', 'Laporan::index');
            
            //  cetak Laporan
            $routes->get('/laporan/cetakSemua', 'Laporan::cetakSemua');
            $routes->get('/laporan/cetakPeriode', 'Laporan::cetakPeriode');
            $routes->get('/laporan/cetakStruk/(:num)', 'Laporan::cetakStruk/$1');
            
            // ROUTES BARU: User Management - Hanya pemilik
            $routes->get('/user', 'User::index');
            $routes->get('/user/create', 'User::create');
            $routes->post('/user/store', 'User::store');
            $routes->get('/user/edit/(:num)', 'User::edit/$1');
            $routes->post('/user/update/(:num)', 'User::update/$1');
            $routes->get('/user/delete/(:num)', 'User::delete/$1');
            $routes->get('/user/toggleStatus/(:num)', 'User::toggleStatus/$1');

        // ================== SISTEM PAKAR ROUTES ==================
        $routes->group('admin', ['filter' => 'auth', 'filter' => 'role:pemilik'], function($routes) {
            
            // ========== DASHBOARD SISTEM PAKAR ==========
            $routes->get('sistem-pakar', 'Admin\DashboardSistemPakar::index');
            
            // ========== MANAJEMEN PENYAKIT ==========
            $routes->get('penyakit', 'Admin\Penyakit::index');
            $routes->get('penyakit/create', 'Admin\Penyakit::create');
            $routes->post('penyakit/store', 'Admin\Penyakit::store');
            $routes->get('penyakit/edit/(:num)', 'Admin\Penyakit::edit/$1');
            $routes->post('penyakit/update/(:num)', 'Admin\Penyakit::update/$1');
            $routes->get('penyakit/delete/(:num)', 'Admin\Penyakit::delete/$1');
            $routes->get('penyakit/detail/(:num)', 'Admin\Penyakit::detail/$1');
            $routes->get('penyakit/generate-kode', 'Admin\Penyakit::generateKode'); // API
            
            // ========== MANAJEMEN GEJALA ==========
            $routes->get('gejala', 'Admin\Gejala::index');
            $routes->get('gejala/create', 'Admin\Gejala::create');
            $routes->post('gejala/store', 'Admin\Gejala::store');
            $routes->get('gejala/edit/(:num)', 'Admin\Gejala::edit/$1');
            $routes->post('gejala/update/(:num)', 'Admin\Gejala::update/$1');
            $routes->get('gejala/delete/(:num)', 'Admin\Gejala::delete/$1');
            $routes->get('gejala/generate-kode', 'Admin\Gejala::generateKode'); // API
            
            // ========== MANAJEMEN ATURAN (Knowledge Base) ==========
            $routes->get('aturan', 'Admin\Aturan::index');
            $routes->get('aturan/create', 'Admin\Aturan::create');
            $routes->post('aturan/store', 'Admin\Aturan::store');
            $routes->get('aturan/edit/(:num)', 'Admin\Aturan::edit/$1');
            $routes->post('aturan/update/(:num)', 'Admin\Aturan::update/$1');
            $routes->get('aturan/delete/(:num)', 'Admin\Aturan::delete/$1');
            
            // Bulk Create - Tambah banyak gejala sekaligus untuk 1 penyakit
            $routes->get('aturan/bulk-create/(:num)', 'Admin\Aturan::bulkCreate/$1');
            $routes->post('aturan/bulk-store', 'Admin\Aturan::bulkStore');
        }
);


});