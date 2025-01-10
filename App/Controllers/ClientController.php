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

        // if ($user) {
        //     var_dump($user->getName());
        // } else {
        //     echo "No user authenticated!";
        // }

        $accounts = Account::loadByUserId($this->db, $user->getId());
        $this->render('client/index', ['account' => $accounts]);
    }

    public function transfer(){
        $this->render('client/transfer');
    }

    public function profile(){

        $user = Auth::user();
        if (!$user) {
            die('No user authenticated!');
        }

        $this->render('client/profile', ['user'=> Auth::user()]);
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

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? null;
            $email = $_POST['email'] ?? null;

            $user = Auth::user();
            if ($user) {
                $user->setName($name);
                $user->setEmail($email);
                $user->save(); 
            }

            header('Location: /profile');
            exit;
        }
    }
    
}


