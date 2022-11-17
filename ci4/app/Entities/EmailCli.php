<?php namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EmailCli extends Entity{
    public function __toString()
    {
        return $this->email;
    }
}