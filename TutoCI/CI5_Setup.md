# Setup

## prérequis :
- php8 
```bash
sudo apt-get update && sudo apt-get install php8.0
```
- mbstring 
```bash
sudo apt-get install php-mbstring
```
- curl
```bash
sudo apt-get install curl
```
- intl
```bash
sudo apt-get install php-intl
```
- xml
```bash
sudo apt-get install php-xml
```


## Démarrage en local avec spark

### Commande

```bash
php spark serve
```

### BaseURL
*ci4/.env*
```
app.baseURL = http://localhost:8080/
```
*ci4/app/Config/App.php*
```php
public $baseURL = '';
```
Utilisé à la place de php -S. Nécessite ”intl”  pour cette commande.


## Démarrage en local avec php -S OU apache

### Commande en local

```bash
php -S localhost:8080
```

### BaseURL avec php -S
*ci4/.env*
```
    app.baseURL =http://localhost/public/
```
*ci4/app/Config/App.php*
```php
    public $baseURL = '';
```

### BaseURL avec apache
*ci4/.env*
```
    app.baseURL =http://localhost/public/
```
*ci4/app/Config/App.php*
```php
    public $baseURL = '';
```

**Très important** sinon il sera difficle d'accéder au fichier css, js, aux images et à faire des liens entre les pages.

### Autre information apache

Autoriser les droits de apache pour writable et ses sous dossier 
```bash
chmod -R 755 writable/ 
chown -R www-data:www-data writable/
```
Si ça marche sans pour apache, c'est parceque j'ai 777 writable mdr.

A vérifier mais intl est aussi nécessaire soit pour apache soit pour les deux cas.
A vérifier aussi la nécessité de composer.

## Vérifier mode:

ci4/.env:

```bash
CI_ENVIRONMENT = development
```


**De manière général attentio à la majuscule pour les nom de fichier de classes et au namspaces !!**