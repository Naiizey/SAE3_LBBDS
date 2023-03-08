<?php

namespace App\Models;

use \App\Entities\Glossaire as Glossaire_Entity;
use CodeIgniter\Model;
use Exception;

class Glossaire extends Model
{
    protected $table = 'sae3.glossaire_vendeur';
    protected $primaryKey = 'id_quidi';
}

?>