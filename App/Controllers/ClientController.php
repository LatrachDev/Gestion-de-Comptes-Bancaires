<?php

namespace App\Controllers;

use App\Models\Account;
use Core\Auth;
use Core\BaseController;
use Helpers\Database;

class ClientController extends BaseController {

    private $db;
    public function __construct()
    {
        parent::__construct();
        Auth::requireClient();
        $this->db = new Database();
        $this->db->connect();

    }
    public function index():void
    {

        $user = Auth::user();
        $accounts = Account::loadByUserId($this->db, $user->getId());
        $this->render('client/index', ['account' => $accounts]);
    }

    public function transfer(){
        $this->render('client/transfer');
    }

    public function profile(){
        $this->render('client/profile');
    }

    public function history(){
        $this->render('client/history');
    }

    public function compte(){
        $this->render('client/compte');
    }
    public function benefit(){
        $this->render('client/benefit');
    }
}


