<?php

namespace Config;

// Create a new instance of our RouteCollection class.
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
#$routes->setDefaultController('Home');
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
    $routes->get('/', 'Home');
    $routes->get('/index', 'Home::index');

    

    $routes->get('/connexion', 'Home::connexion');
    $routes->post('/connexion', 'Home::connexion');
    $routes->get('/connexion/(401)', 'Home::connexion/$1');
    $routes->post('/connexion/(401)', 'Home::connexion/$1');
    $routes->get('/inscription', 'Home::inscription');
    $routes->post('/inscription', 'Home::inscription');
    $routes->get('/inscription/(401)', 'Home::inscription/$1');
    $routes->post('/inscription/(401)', 'Home::inscription/$1');
    $routes->get('/lstCommandes', 'Home::lstCommandes');

    $routes->get('/mdpOublie', 'MdpOublie::mdpOublie');
    $routes->post('/mdpOublie', 'MdpOublie::mdpOublie');
    $routes->get('/obtenirCode', 'MdpOublie::obtenirCode');
    $routes->post('/obtenirCode', 'MdpOublie::obtenirCode');
    $routes->get('/validerCode', 'MdpOublie::validerCode');
    $routes->post('/validerCode', 'MdpOublie::validerCode');

    $routes->get('/produit', 'Home::produit');
    $routes->get('/produit/(:num)', 'Home::produit/$1');
    $routes->post('/produit/(:num)', 'Home::produit/$1');

    $routes->get('/panier', 'Panier::getProduitPanierClient');
    $routes->get('/panier/vider', 'Panier::viderPanier'); 
    $routes->get('/panier/supprimer/(:num)', 'Panier::supprimerProduitPanier/$1');
    $routes->post('/panier/ajouter/(:num)', 'Panier::ajouterPanier/$1/');

    $routes->get('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'Panier::modifierProduitPanier/$1/$2');
    $routes->put('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'Panier::modifierProduitPanier/$1/$2');
    $routes->options('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'Panier::sendCors/$1/$2');

    $routes->get('/catalogue', 'Home::catalogue');
    $routes->get('/catalogue/(:num)', 'Home::catalogue/$1');

    $routes->get('/test', 'Test::test2');
    $routes->get('/panier', 'Panier');

    $routes->get('/import', 'Import::index');
    $routes->post('/import/upload', 'Import::upload');

    $routes->get('/destroy', 'Test::destroySession');

    $routes->get('/commandes', 'Home::commandeTest',['filter' => 'connexion']);

    if(session()->has("numero")){
        $routes->get('/espaceClient', 'EspaceClient::index');
    }
    else{
        $routes->get('/espaceClient', 'Home::connexion');
    }

##param uri (:any) et dans methode /$1

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
