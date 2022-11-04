<?php

namespace Config;

// Create a new instance of our RouteCollection class.
use App\Controllers\UserController;

$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'HomeController::index');
$routes->get('users', 'UserController::index');
$routes->get( 'login', 'UserController::logIn');
$routes->get('logout', 'UserController::logOut');
$routes->match(['get', 'post'], 'register', 'UserController::register');

$routes->get('researcher/news', 'NewsController::index');

$routes->get('researcher/map', 'ResearcherController::map');
$routes->get('(:segment)/patient', 'ResearcherController::getPatient');
$routes->get('researcher/patient/(:segment)', 'ResearcherController::getPatient/$1');
$routes->match(['get'], 'researcher/notes/', 'ResearcherController::note/$1');
$routes->match(['get', 'post'], 'researcher/notes/(:segment)', 'ResearcherController::note/$1');
$routes->get('researcher/notes/(:segment)', 'ResearcherController::note/$1');
$routes->match(['get', 'post'],'researcher/note', 'ResearcherController::postNote');
$routes->get('physician/patient/(:segment)', 'PhysicianController::getPatient/$1');

$routes->get('github', 'GitHubAuthController::index');
$routes->get('github/login', 'GitHubAuthController::login');

$routes->get('google', 'GoogleAuthController::index');

$routes->get('twitter', 'TwitterAuthController::index');
$routes->get('twitter/login', 'TwitterAuthController::login');

$routes->get('(:segment)', 'DashboardController::index/$1');

/*$routes->get('dashboard/patient', 'PatientController::index');
$routes->get('dashboard/physician', 'PhysicianController::index');
$routes->get('dashboard/researcher', 'ResearcherController::index');*/

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
