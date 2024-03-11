<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'Authentication/login_view';
$route['404_override'] = 'Errors_page/not_found';
$route['translate_uri_dashes'] = false;

// Authentication
$route['login_view'] = 'Authentication/login_view';
$route['login'] = 'Authenticaion/login';
$route['logout'] = 'Authenticaion/logout';
$route['change_password_view'] = 'Authentication/change_password_view';
$route['change_password'] = 'Authentication/change_password';

// Home
$route['dashboard'] = 'Dashboard';
$route['data_payroll'] = 'Data_payroll';

// Absensi
$route['timesheet'] = 'Timesheet';
$route['data_payroll'] = 'Data_payroll';
$route['spl'] = 'SPL';
$route['absensi'] = 'Absensi';

// Master Data
$route['karyawan'] = 'Karyawan';
$route['gaji'] = 'Gaji';
$route['kenaikan_gaji'] = 'Kenaikan_gaji';
$route['cuti'] = 'Hari_libur';
$route['jenis_data'] = 'Jenis_keterangan';
$route['keterangan'] = 'Keterangan';

// Authority
$route['users'] = 'Authority';

// Error
$route['not_found'] = 'Errors_page/not_found';
$route['unauthorized'] = 'Errors_page/unauthorized';