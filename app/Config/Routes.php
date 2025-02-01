<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Login

// index
$routes->get('/', 'Masuk::index');
$routes->post('/proses', 'Masuk::proses');
$routes->get('/proses', 'Masuk::proses');
// Admin
$routes->get('/admin', 'Admin::index_main');
$routes->get('/admin/manage-data', 'Admin::index');
$routes->get('/admin/manage-data/edit/(:num)', 'Admin::edit/$1'); 
$routes->post('/admin/manage-data/edit/(:num)', 'Admin::edit/$1'); // Untuk meng-handle POST request pada form edit
$routes->delete('/admin/manage-data/delete/(:num)', 'Admin::delete/$1');
$routes->get('/admin/manage-data/add/', 'Admin::add');
$routes->post('/admin/manage-data/add/', 'Admin::add');
$routes->post('/admin/manage-data/search/', 'Admin::search');
$routes->get('/admin/manage-data/search/', 'Admin::search');
$routes->get('/admin/notification/', 'Admin::notif');
$routes->delete('/admin/notification/delete/(:num)', 'Admin::hapus_notif/$1');
$routes->get('permission/erly-access/api/version/v1', 'Admin::api', ['filter' => 'cors']);
$routes->get('/about', 'Admin::about');

$routes->get('admin/manage-user', 'ManageUser::index');
$routes->post('admin/manage-user/add/', 'ManageUser::add');
$routes->get('admin/manage-user/add', 'ManageUser::add');
$routes->post('admin/manage-user/edit/(:num)', 'ManageUser::edit/$1');
$routes->get('admin/manage-user/edit/(:num)', 'ManageUser::edit/$1');
$routes->delete('admin/manage-user/delete/(:num)', 'ManageUser::delete/$1');
$routes->get('admin/manage-user/delete/(:num)', 'ManageUser::delete/$1');
$routes->get('/admin/manage-user/search/', 'ManageUser::search');
$routes->post('/admin/manage-user/search/', 'ManageUser::search');
// Member
$routes->get('/member', 'Member::index');
$routes->get('member/detail/(:any)', 'Member::detail/$1');
$routes->get('/logout', 'Member::logout');
$routes->post('member/detail/pinjam', 'Member::pinjam');
$routes->get('/member/search', 'Member::search');
$routes->post('/member/search', 'Member::search');
$routes->get('member/detail/pinjam', 'Member::pinjam');
// Banned
$routes->get('/banned', 'Admin::banned');