<?php

namespace App\Controllers;
use Core\BaseController;

class AdminController extends BaseController
{
    public function index(): void
    {
        $this->render('admin/index');
    }

    public function string(){
        echo 'test';
    }
}
