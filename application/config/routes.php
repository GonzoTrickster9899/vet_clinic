<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'welcome';

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

$route['customers'] = 'customers/index';
$route['customers/add'] = 'customers/add';
$route['customers/edit/(:num)'] = 'customers/edit/$1';
$route['customers/delete/(:num)'] = 'customers/delete/$1';

$route['pets'] = 'pets/index';
$route['pets/add'] = 'pets/add';
$route['pets/edit/(:num)'] = 'pets/edit/$1';
$route['pets/view/(:num)'] = 'pets/view/$1';
$route['pets/delete_image/(:num)'] = 'pets/delete_image/$1';

$route['appointments'] = 'appointments/index';
$route['appointments/add'] = 'appointments/add';
$route['appointments/edit/(:num)'] = 'appointments/edit/$1';

$route['inventory'] = 'inventory/index';
$route['inventory/add'] = 'inventory/add';
$route['inventory/edit/(:num)'] = 'inventory/edit/$1';

$route['sales'] = 'sales/index';
$route['sales/add'] = 'sales/add';

