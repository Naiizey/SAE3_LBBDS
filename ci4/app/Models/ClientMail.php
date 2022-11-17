<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientMail extends Model{
    protected $table = "sae3.client_mail";
    protected $primaryKey = "num_compte";

    protected $allowedFields = ["num_compte","email"];

    protected $returnType = \App\Entities\EmailCli::class;

    public function getMail($id){
        return $this->where('num_compte',$id)->findAll();
    }
}