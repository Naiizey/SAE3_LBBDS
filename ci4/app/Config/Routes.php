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

$routes->get('/test2','Test::test4');

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                     Client                                      ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/
$routes->get('/', 'client\Home');
$routes->get('/index', 'client\Home::index');

$routes->get('/connexion', 'client\Home::connexion');
$routes->post('/connexion', 'client\Home::connexion');
$routes->get('/connexion/(401)', 'client\Home::connexion/$1');
$routes->post('/connexion/(401)', 'client\Home::connexion/$1');
$routes->get('/connexion/retourProduit/(:num)', 'client\Home::produit/$1' ,['filter' => 'connexion']);
$routes->get('/connexion/retourPanier', 'client\Panier::getProduitPanierClient' ,['filter' => 'connexion']);

$routes->get('/inscription', 'client\Home::inscription');
$routes->post('/inscription', 'client\Home::inscription');
$routes->get('/inscription/(401)', 'client\Home::inscription/$1');
$routes->post('/inscription/(401)', 'client\Home::inscription/$1');

$routes->get('/mdpOublie', 'client\MdpOublie::mdpOublie');
$routes->post('/mdpOublie', 'client\MdpOublie::mdpOublie');
$routes->get('/obtenirCode', 'client\MdpOublie::obtenirCode');
$routes->post('/obtenirCode', 'client\MdpOublie::obtenirCode');
$routes->get('/validerCode', 'client\MdpOublie::validerCode');
$routes->post('/validerCode', 'client\MdpOublie::validerCode');

$routes->get('/produit', 'client\Home::produit');
$routes->get('/produit/(:num)', 'client\Home::produit/$1');
$routes->post('/produit/(:num)', 'client\Home::produit/$1', ['filter' => 'connexion']);
$routes->get('/produit/(:num)/(:num)', 'client\Home::produit/$1/$2');
$routes->post('/produit/(:num)/(:num)', 'client\Home::produit/$1/$2', ['filter' => 'connexion']);

$routes->get('/panier', 'client\Panier::getProduitPanierClient');
$routes->post('/panier', 'client\Panier::getProduitPanierClient');
$routes->get('/panier/vider', 'client\Panier::viderPanier');
$routes->get('/panier/supprimer/(:num)', 'client\Panier::supprimerProduitPanier/$1');
$routes->post('/panier/ajouter/(:num)', 'client\Panier::ajouterPanier/$1/');
$routes->get('/panier/ajouter/(:num)/(:num)', 'client\Panier::ajouterPanier/$1/$2');

$routes->get('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'client\Panier::modifierProduitPanier/$1/$2');
$routes->put('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'client\Panier::modifierProduitPanier/$1/$2');
$routes->options('/panier/modifier/quantite/([0-9]+£[0-9]+)/(:num)', 'client\Panier::sendCors/$1/$2');

$routes->get('/paiement', 'client\Home::paiement', ['filter' => 'connexion']);
$routes->post('/paiement', 'client\Home::paiement', ['filter' => 'connexion']);

$routes->get('/catalogue', 'client\Home::catalogue');
$routes->get('/catalogue/(:num)', 'client\Home::catalogue/$1');

$routes->get('/test', 'Test::test2');

$routes->get('/commandes', 'client\Home::lstCommandes',['filter' => 'connexion']);
$routes->get('/commandes/(:alphanum)','client\Home::lstCommandes/$1',['filter' => 'connexion']);

$routes->get('/produits/page/(:num)','client\Produits::getAllProduitSelonPage/$1');
$routes->options('/produits/page/(:num)','client\Produits::getAllProduitSelonPage/$1');

$routes->get('/livraison','client\Home::infoLivraison',['filter' => 'connexion']);
$routes->post('/livraison','client\Home::infoLivraison',['filter' => 'connexion']);
$routes->get('/facture','client\Home::facture',['filter' => 'connexion']);
$routes->post('/facture','client\Home::facture',['filter' => 'connexion']);

$routes->get('/profil', 'client\Home::profil' ,['filter' => 'connexion']);
$routes->post('/profil', 'client\Home::profil' ,['filter' => 'connexion']);

$routes->get('/validation', 'client\Home::validation' );
$routes->post('/validation', 'client\Home::validation' );

/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                    Admin                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

$routes->get('/admin', 'admin\Home');

$routes->get('/admin/destroyClient', 'admin\Home::destroySessionClient');
$routes->get('/admin/destroyVendeur', 'admin\Home::destroySessionVendeur');

$routes->get('/admin/clients', 'admin\Home::lstClients/liste');
$routes->get('/admin/clients/bannir', 'admin\Home::lstClients/bannir');
$routes->post('/admin/clients/bannir', 'admin\Home::lstClients/bannir');
$routes->get('/admin/clients/(:num)', 'admin\Home::lstClients/bannir');
$routes->post('/admin/clients/(:num)', 'admin\Home::lstClients/bannir');

$routes->get('/admin/vendeurs', 'admin\Home::lstVendeurs');
$routes->get('/admin/vendeurs/inscription', 'admin\Home::inscriptionVendeur');
$routes->post('/admin/vendeurs/inscription', 'admin\Home::inscriptionVendeur');

$routes->get('/admin/bannissements', 'admin\Home::bannissements');
$routes->post('/admin/bannissements', 'admin\Home::bannissements');

$routes->get('/admin/signalements', 'admin\Home::lstSignalements');
$routes->get('/admin/signalements/(:num)', 'admin\Home::lstSignalements/$1');

$routes->get('/admin/avis', 'admin\Home::lstAvis');
$routes->get('/admin/avis/(:num)', 'admin\Home::lstAvis/$1');

$routes->get('/admin/profil/client', 'admin\Home::profilClient');
$routes->get('/admin/profil/client/(:num)', 'admin\Home::profilClient/$1');
$routes->post('/admin/profil/client/(:num)', 'admin\Home::profilClient/$1');

$routes->get('/admin/profil/vendeur', 'admin\Home::profilVendeur');
$routes->get('/admin/profil/vendeur/(:num)', 'admin\Home::profilVendeur/$1');
$routes->post('/admin/profil/vendeur/(:num)', 'admin\Home::profilVendeur/$1');

$routes->get('/admin/glossaire/(:num)', 'admin\Home::glossaire/$1');
/*
┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃                                  Vendeur                                        ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
*/

$routes->get('/vendeur/import/entetes','vendeur\Import::getentetes',['filter' => 'vendeur']);

$routes->get('/vendeur/import', 'vendeur\Import::index/true', ['filter' => 'vendeur']);
$routes->post('/vendeur/import/upload','vendeur\Import::upload', ['filter' => 'vendeur']);

$routes->get('vendeur/commandes','vendeur\Home::lstCommandes',['filter' => 'vendeur']);
$routes->get('vendeur/commandes/(:alphanum)','vendeur\Home::lstCommandes/$1',['filter' => 'vendeur']);
$routes->get('vendeur/import', 'vendeur\Import::index/true',['filter' => 'vendeur']);
$routes->post('vendeur/import/upload','vendeur\Import::upload',['filter' => 'vendeur']);

$routes->get('/vendeur/profil', 'vendeur\Home::profil',['filter' => 'vendeur']);
$routes->post('/vendeur/profil', 'vendeur\Home::profil',['filter' => 'vendeur']);

$routes->get('vendeur/connexion','vendeur\Home::connexion');
$routes->post('vendeur/connexion','vendeur\Home::connexion');

$routes->get('/vendeur/catalogue', 'vendeur\Home::catalogue', ['filter' => 'vendeur']);

$routes->get('vendeur/catalogue(:num)', 'vendeur\Home::catalogue/$1',['filter' => 'vendeur']);

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
