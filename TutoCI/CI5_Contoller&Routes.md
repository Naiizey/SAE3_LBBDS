
# Routes et controller

## Définir un controller:

### Def controller

*ci4/app/Controllers/Home.php*

```php
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('page_accueil/index.php');
    }

    public function connexion()
    {
        return view('page_accueil/connexion.php');
    }
}
```

### Def routes

*ci4/app/Config/Routes.php*

```php
$routes->setDefaultNamespace('App\Controllers');
...

$routes->get('/', 'Home::index');
$routes->get('/connexion', 'Home::connexion');
```

On peut aussi mettre une méthode par défaut d’où

```php
$routes->setDefaultMethod('index');

$routes->get('/', 'Home');
```

## Paramètres:

### Contoller

*ci4/app/Controllers/Home.php*

```php
public function connexion($id=null)
    {
        return view('page_accueil/connexion.php');
    }
```

### Route

```php
$routes->get('/connexion/(:any)', 'Home::connexion/$1');
```

il existe aussi (:num), (:alpha), (:alphanum) mais aussi (:segment) et (:hash) 

Regex possible aussi avec (<*******regex>)*******  ou addPlaceHolder(<***nom***>, <*******regex*******>).

## Plusieurs routes à la fois:

### Groupage

```php
$routes->group('admin', static function ($routes) {
    $routes->get('users', 'Admin\Users::index');
    $routes->get('blog', 'Admin\Blog::index');
});
```

on a donc les liens admin/users et admin/blog

### Mapping

```php
<?php

$multipleRoutes = [
    'product/(:num)'      => 'Catalog::productLookupById',
    'product/(:alphanum)' => 'Catalog::productLookupByName',
];

$routes->map($multipleRoutes);
```

## Redirection:

### Nommage route:

```php
$routes->get('users', 'Admin\Users::index',['as' => 'principal']);
```

### Dans un controller:

```php
redirect()->to(site_url('users'));
//ou
redirect()->route('principal');
```

### Dans route:

```php
$routes->addRedirect('/', 'principal');
```

## Récupération post/get:

### getVar() dans un controller

```php
$this->request->getVar('<nom_var>')
```

### Attention à post !!

```php
$routes->post('connexion', 'Connexion::index');
//ou
$routes->match(['get', 'post'],'connexion', 'Connexion::index');
```

En effet, post n’est pas un requête get 

## Notion intéressant les filter

```php
$routes->get('users', 'Admin\Users::index'
,['as' => 'principal', 'filter' => '\App\Filters\SomeFilter::class']);
```

[https://codeigniter4.github.io/CodeIgniter4/incoming/filters.html?highlight=filter#creating-a-filter](https://codeigniter4.github.io/CodeIgniter4/incoming/filters.html?highlight=filter#creating-a-filter)

Permet de vérifier la connexion par exemple
