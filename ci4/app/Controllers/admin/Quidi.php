<?php namespace App\Controllers\Admin;


use App\Controllers\BaseQuidi;


class Quidi extends BaseQuidi
{


    public function __construct()
    {
        parent::__construct();
        $this->context="admin";
        $this->session=null;
        $this->model=model("\App\Models\ProduitQuidiAdmin");
        $this->modelJson=model("\App\Models\ProduitQuidiAdminJson");
    }







}