<?php

namespace App\Models;

use \App\Entities\Signalement;
use CodeIgniter\Model;
use Exception;

/** 
 * Model de classe LstSignalements qui permet de récuperer un signalement
 * 
 * 
 * @see TutoCI/CI5_BDD
 * @return \App\Entities\Signalement
 */
class LstSignalements extends Model
{
    protected $table      = 'sae3.signalement';
    protected $primaryKey = 'id_signal';

    protected $useAutoIncrement = true;

    protected $returnType     = Signalement::class;
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['id_signal','raison','num_avis','num_compte'];
}