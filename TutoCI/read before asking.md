# Les Problèmes

## postgre connexion error
erreur nommée `call to undefined function pg_connect()`
solution: Restart ci4

## require d'un fichier dans un autre directory

```php
require(__DIR__."/../page_accueil/footer.php");
```

## erreur 
oops we seem to have hit a snag, please try later

solution vérifiez que le fichier .env est bien dans le dossier ci4 et que il est bien en .env et pas en env
sinon passez en mode développeur