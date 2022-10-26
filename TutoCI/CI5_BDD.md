# Base de données : le modèle et l’entité

## Définition Model

*ci4/Model/…*

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
```

**Attention, pour ma part en tout cas,tous les noms de colonnes sont tranformé en minuscule**

### $table

définit table utilisé

### $useAutoIncrement

si notre table utilise auto incrémentation ou non

### $allowedDeletes

colonne qui seront modifiable par notre model.

**Lien pour voir méthode**: [https://codeigniter4.github.io/CodeIgniter4/models/model.html](https://codeigniter4.github.io/CodeIgniter4/models/model.html)

## Définition entité

*ci4/Entities/…*

### L’entité:

```php


namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    // ...déjà utilisable sans rien
}
```

### Le model:

```php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    //...
    protected $returnType    = \App\Entities\User::class;
   //...
}
```

## Utilisation:

```php
$user = $userModel->find($id);

// Display
echo $user->username;
echo $user->email;

// Updating
unset($user->username);

if (! isset($user->username)) {
    $user->username = 'something new';
}

$userModel->save($user);

// Create
$user           = new \App\Entities\User();
$user->username = 'foo';
$user->email    = 'foo@example.com';
$userModel->save($user);

//Fill
$data = $this->request->getPost();

$user = new \App\Entities\User();
$user->fill($data);
$userModel->save($user);
```

On peut aussi ajouter des méthode à notre entité.

## Voir plus

Voir property mapping, le data mapping ou autre

[https://codeigniter4.github.io/CodeIgniter4/models/entities.html](https://codeigniter4.github.io/CodeIgniter4/models/entities.html)