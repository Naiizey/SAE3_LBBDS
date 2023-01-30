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

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                    Client                                       ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
$routes->get('/', 'Client');
$routes->get('/index', 'Client::index');

$routes->get('/connexion', 'Client::connexion');
$routes->post('/connexion', 'Client::connexion');
$routes->get('/connexion/(401)', 'Client::connexion/$1');
$routes->post('/connexion/(401)', 'Client::connexion/$1');
$routes->get('/connexion/retourProduit/(:num)', 'Client::produit/$1' ,['filter' => 'connexion']);
$routes->get('/connexion/retourPanier', 'Panier::getProduitPanierClient' ,['filter' => 'connexion']);

$routes->get('/inscription', 'Client::inscription');
$routes->post('/inscription', 'Client::inscription');
$routes->get('/inscription/(401)', 'Client::inscription/$1');
$routes->post('/inscription/(401)', 'Client::inscription/$1');

$routes->get('/mdpOublie', 'MdpOublie::mdpOublie');
$routes->post('/mdpOublie', 'MdpOublie::mdpOublie');
$routes->get('/obtenirCode', 'MdpOublie::obtenirCode');
$routes->post('/obtenirCode', 'MdpOublie::obtenirCode');
$routes->get('/validerCode', 'MdpOublie::validerCode');
$routes->post('/validerCode', 'MdpOublie::validerCode');

$routes->get('/produit', 'Client::produit');
$routes->get('/produit/(:num)', 'Client::produit/$1');
$routes->post('/produit/(:num)', 'Client::produit/$1', ['filter' => 'connexion']);
$routes->get('/produit/(:num)/(:num)', 'Client::produit/$1/$2');
$routes->post('/produit/(:num)/(:num)', 'Client::produit/$1/$2', ['filter' => 'connexion']);

$routes->get('/panier', 'Panier::getProduitPanierClient');
$routes->post('/panier', 'Panier::getProduitPanierClient');
$routes->get('/panier/vider', 'Panier::viderPanier');
$routes->get('/panier/supprimer/(:num)', 'Panier::supprimerProduitPanier/$1');
$routes->post('/panier/ajouter/(:num)', 'Panier::ajouterPanier/$1/');
$routes->get('/panier/ajouter/(:num)/(:num)', 'Panier::ajouterPanier/$1/$2');

$routes->get('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'Panier::modifierProduitPanier/$1/$2');
$routes->put('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'Panier::modifierProduitPanier/$1/$2');
$routes->options('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'Panier::sendCors/$1/$2');

$routes->get('/paiement', 'Client::paiement', ['filter' => 'connexion']);
$routes->post('/paiement', 'Client::paiement', ['filter' => 'connexion']);

$routes->get('/catalogue', 'Client::catalogue');
$routes->get('/catalogue/(:num)', 'Client::catalogue/$1');

$routes->get('/test', 'Test::test2');

$routes->get('/commandes', 'Client::lstCommandesClient',['filter' => 'connexion']);

$routes->get('/commandes/detail/(:alphanum)','Client::detail/$1',['filter' => 'connexion']);//['filter' => 'connexion']

$routes->get('/produits/page/(:num)','Produits::getAllProduitSelonPage/$1');
$routes->options('/produits/page/(:num)','Produits::getAllProduitSelonPage/$1');

$routes->get('/livraison','Client::infoLivraison',['filter' => 'connexion']);
$routes->post('/livraison','Client::infoLivraison',['filter' => 'connexion']);
$routes->get('/facture','Client::facture',['filter' => 'connexion']);
$routes->post('/facture','Client::facture',['filter' => 'connexion']);

$routes->get('/espaceClient', 'Client::espaceClient' ,['filter' => 'connexion']);
$routes->post('/espaceClient', 'Client::espaceClient' ,['filter' => 'connexion']);

$routes->get('/validation', 'Client::validation' );
$routes->post('/validation', 'Client::validation' );

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                    Admin                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

$routes->get('/admin', 'Admin');

$routes->get('/admin/destroy', 'Admin::destroySession');

$routes->get('/admin/clients', 'Admin::lstClients/liste');
$routes->get('/admin/clients/bannir', 'Admin::lstClients/bannir');
$routes->post('/admin/clients/bannir', 'Admin::lstClients/bannir');
$routes->get('/admin/clients/(:num)', 'Admin::lstClients/bannir');
$routes->post('/admin/clients/(:num)', 'Admin::lstClients/bannir');

$routes->get('/admin/vendeurs', 'Admin::lstVendeurs');
$routes->get('/admin/vendeurs/inscription', 'Admin::inscriptionVendeur');
$routes->post('/admin/vendeurs/inscription', 'Admin::inscriptionVendeur');

$routes->get('/admin/bannissements', 'Admin::bannissements');
$routes->post('/admin/bannissements', 'Admin::bannissements');

$routes->get('/admin/signalements', 'Admin::lstSignalements');
$routes->get('/admin/signalements/(:num)', 'Admin::lstSignalements/$1');

$routes->get('/admin/avis', 'Admin::lstAvis');
$routes->get('/admin/avis/(:num)', 'Admin::lstAvis/$1');

$routes->get('/(admin)/espaceClient/(:num)', 'Client::espaceClient/$1/$2');
$routes->post('/(admin)/espaceClient/(:num)', 'Client::espaceClient/$1/$2');

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                  Vendeur                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

$routes->get('/vendeur/import/entetes', 'Import::getentetes');

$routes->get('vendeur/import', 'Import::index/true');
$routes->post('vendeur/import/upload', 'Import::upload');

$routes->get('vendeur/commandesCli', 'Vendeur::lstCommandesVendeur/true');
$routes->get('vendeur/commandesCli/detail/(:alphanum)','Client::detail/$1/true');

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
