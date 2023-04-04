<?php namespace App\Controllers\Admin;


use App\Controllers\BaseQuidi;


class Quidi extends BaseQuidi
{


    public function __construct()
    {
        parent::__construct();
        $this->context="admin";
    }







}