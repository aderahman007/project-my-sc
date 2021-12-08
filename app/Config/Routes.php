<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// Routes Auth
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::auth');
$routes->get('logout', 'Auth::logout');

$routes->group('admin',['filter' => 'auth'], function($routes){
	$routes->get('/', 'Admin::index');
	$routes->get('admin', 'Admin::index');
	$routes->get('dashboard', 'Admin::index');
	$routes->match(['get', 'post'], 'change_password', 'Admin::change_password');
});

$routes->group('petugas', ['filter' => 'auth'], function ($routes) {
	$routes->get('/', 'Petugas::index');
	$routes->get('dashboard', 'Petugas::index');
});

$routes->group('datang', ['filter' => 'auth'], function($routes){
	// Routes Mutasi Datang
	$routes->get('/', 'MutasiDatang::index');
	$routes->get('detail/(:segment)', 'MutasiDatang::detail/$1');
	$routes->post('load', 'MutasiDatang::load');
	$routes->match(['get', 'post'], 'create', 'MutasiDatang::create');
	$routes->match(['get', 'post'], 'update/(:any)', 'MutasiDatang::update/$1');
	$routes->delete('delete/(:num)', 'MutasiDatang::delete/$1');
});

$routes->group('lahir', ['filter' => 'auth'], function($routes){
	// Routes Peristiwa Lahir
	$routes->get('/', 'PeristiwaLahir::index');
	$routes->get('detail/(:segment)', 'PeristiwaLahir::detail/$1');
	$routes->post('load', 'PeristiwaLahir::load');
	$routes->match(['get', 'post'], 'create', 'PeristiwaLahir::create');
	$routes->match(['get', 'post'], 'update/(:any)', 'PeristiwaLahir::update/$1');
	$routes->delete('delete/(:num)', 'PeristiwaLahir::delete/$1');
});

$routes->group('pindah', ['filter' => 'auth'], function($routes){
	// Routes Mutasi Pindah
	$routes->get('/', 'MutasiPindah::index');
	$routes->get('detail/(:segment)', 'MutasiPindah::detail/$1');
	$routes->post('load', 'MutasiPindah::load');
	$routes->post('create', 'MutasiPindah::create');
	$routes->post('update', 'MutasiPindah::update');
	$routes->delete('delete/(:num)', 'MutasiPindah::delete/$1');
});

$routes->group('kematian', ['filter' => 'auth'], function($routes){
	// Routes Peristiwa Kematian
	$routes->get('', 'PeristiwaKematian::index');
	$routes->get('detail/(:segment)', 'PeristiwaKematian::detail/$1');
	$routes->post('load', 'PeristiwaKematian::load');
	$routes->post('create', 'PeristiwaKematian::create');
	$routes->post('update', 'PeristiwaKematian::update');
	$routes->delete('delete/(:num)', 'PeristiwaKematian::delete/$1');
});

$routes->group('kk', ['filter' => 'auth'], function($routes){
	// Routes KK
	$routes->get('', 'Kk::index');
	$routes->get('detail/(:segment)', 'Kk::detail/$1');
	$routes->post('load', 'Kk::loadKK');
	$routes->match(['get', 'post'], 'create', 'Kk::create');
	$routes->match(['get', 'post'], 'update/(:any)', 'Kk::update/$1');
	$routes->delete('delete/(:num)', 'Kk::delete/$1');
});

$routes->group('penduduk', ['filter' => 'auth'], function($routes){
	// Routes Penduduk
	$routes->get('/', 'Penduduk::index');
	// $routes->get('penduduk/search_noKK', 'Penduduk::search_noKK');
	$routes->get('detail/(:segment)', 'Penduduk::detail/$1');
	$routes->post('load', 'Penduduk::loadPenduduk');
	$routes->match(['get', 'post'], 'create', 'Penduduk::create');
	$routes->match(['get', 'post'], 'update/(:any)', 'Penduduk::update/$1');
	$routes->delete('delete/(:num)', 'Penduduk::delete/$1');
	// $routes->match(['get', 'post'], 'non_aktif/(:num)', 'Penduduk::non_aktif/$1');
});

$routes->group('mnj_petugas', ['filter' => 'auth'], function($routes){
	// Routes manajement petugas
	$routes->get('/', 'MnjPetugas::index');
	$routes->get('detail/(:segment)', 'MnjPetugas::detail/$1');
	$routes->post('load', 'MnjPetugas::load');
	$routes->match(['get', 'post'], 'create', 'MnjPetugas::create');
	$routes->match(['get', 'post'], 'update/(:any)', 'MnjPetugas::update/$1');
	$routes->delete('delete/(:num)', 'MnjPetugas::delete/$1');
});

$routes->group('mnj_desa', ['filter' => 'auth'], function($routes){
	// Routes Manajement Desa
	$routes->get('/', 'MnjDesa::index');
	$routes->get('detail/(:segment)', 'MnjDesa::detail/$1');
	$routes->post('load', 'MnjDesa::load');
	$routes->post('update', 'MnjDesa::update');

	// Routes Manajement Dusun
	$routes->post('create_dusun', 'MnjDesa::create_dusun');
	$routes->post('update_dusun', 'MnjDesa::update_dusun');
	$routes->delete('delete_dusun/(:num)', 'MnjDesa::delete_dusun/$1');

	// Routes Manajement Rw
	$routes->post('create_rw', 'MnjDesa::create_rw');
	$routes->post('update_rw', 'MnjDesa::update_rw');
	$routes->delete('delete_rw/(:num)', 'MnjDesa::delete_rw/$1');

	// Routes Manajement Rt
	$routes->post('create_rt', 'MnjDesa::create_rt');
	$routes->post('update_rt', 'MnjDesa::update_rt');
	$routes->delete('delete_rt/(:num)', 'MnjDesa::delete_rt/$1');
});



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
