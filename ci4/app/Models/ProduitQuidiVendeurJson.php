<?php

namespace App\Models;

use \App\Entities\ProduitQuidi as Produit;
use \App\Models\ProduitQuidiModel;
use CodeIgniter\Model;
use Exception;

class ProduitQuidiVendeurJson Extends ProduitQuidiVendeur
{
    protected $table      = 'sae3.produit_quidi_vendeur_json';
 }