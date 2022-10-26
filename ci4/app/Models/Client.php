<?php

namespace App\Models;

use CodeIgniter\Model;

class Client extends Model
{
    protected $table      = 'client';
    protected $primaryKey = 'numero';

    protected $useAutoIncrement = false;

    protected $returnType     = \App\Entities\Client::class;
    protected $useSoftDeletes = false;

    protected $allowedFields = ['numero', 'nom','prenom','pseudo','mdp'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}