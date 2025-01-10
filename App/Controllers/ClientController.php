<?php

namespace App\Controllers;

use App\Models\Account;
use Core\Auth;
use Core\BaseController;
use Helpers\Database;

class ClientController extends BaseController
{

    private $db;
    public function __construct()
    {
        parent::__construct();
        Auth::requireClient();
        $this->db = new Database();
        $this->db->connect();
    }
    public function index(): void
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

    public function transfer()
    {
        $this->render('client/transfer');
    }

    public function profile()
    {

        $user = Auth::user();
        if (!$user) {
            die('No user authenticated!');
        }

        $this->render('client/profile', ['user' => Auth::user()]);
    }


    public function history()
    {
        $this->render('client/history');
    }

    public function compte()
    {
        $user = Auth::user();

        if (!$user) {
            die('No user authenticated!');
        }

        $accounts = Account::loadByUserId($this->db, $user->getId());
        $this->render('client/compte', ['account' => $accounts]);
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

    public function fundAccount()
    {
        $account = new Account($this->db);
        if (!$account->loadById($_POST['account_id'])) {
            $this->setFlash('compte', 'Account not found', 'error');
            header('Location: /compte');
            exit;
        }
        $amount = (float) $_POST['amount'] ?? null;
        if (!$amount) {
            $this->setFlash('compte', 'set a funding amount', 'error');
            header('Location: /compte');
            exit;
        }
        if (!$account->deposit($amount)) {
            $this->setFlash('compte', 'failed to deposit', 'error');
            header('Location: /compte');
            exit;
        } else {
            $this->setFlash('compte', 'funded successfully','success');
            header('Location: /compte');
            exit;
        }
    }

    public function withdraw()
    {
        $account = new Account($this->db);

        if (!$account->loadById($_POST['account_id'])) {
            $this->setFlash('compte', 'Account not found', 'error');
            header('Location: /compte');
            exit;
        }
        
        if ($account->getAccountType() == 'savings') {
            $this->setFlash('compte', 'cant  withdraw fom savings', 'error');
            header('Location: /compte');
            exit;
        }

        $amount = (float) $_POST['amount'] ?? null;
        if (!$amount) {
            $this->setFlash('compte', 'set a funding amount', 'error');
            header('Location: /compte');
            exit;
        }

        $success = $account->withdraw($amount);
        if (! $success) {
            $this->setFlash('compte', 'failed to withdraw', 'error');
            header('Location: /compte');
            exit;
        }

        if ($success === 10) {
            $this->setFlash('compte', 'sir ta tjm3 lflos w aji', 'error'); 
            header('Location: /compte');
            exit;
        }
        $this->setFlash('compte', 'withdrawed successfully','success');
        header('Location: /compte');
        exit;
    }

    // transfrer
    // sending account is account_id
    // receiving account is receiving_id
    // if sending is savings and receiving->userId != Auth::user()->getId print error
    // else do the transfar
}
