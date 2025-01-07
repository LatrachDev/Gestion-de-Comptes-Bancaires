<?php

namespace App\Controllers;
use Core\BaseController;

class ClientController extends BaseController {
    public function index():void
    {
        $this->render('client/index');
    }
}

