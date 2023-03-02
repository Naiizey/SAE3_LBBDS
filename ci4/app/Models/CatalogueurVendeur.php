<?php

namespace App\Models;

use \App\Entities\Catalogueur as Catalogueur_Entity;
use CodeIgniter\Model;
use Exception;

class Catalogueur extends Model
{
    protected $table = 'sae3.catalogueur_vendeur';
    protected $primaryKey = 'num_catalogueur';
}

?>