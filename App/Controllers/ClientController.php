<?php

namespace App\Controllers;

use App\Models\Account;
use App\Models\Transaction;
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
        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $user = Auth::user();

            if (!$user) {
                die('No user authenticated!');
            }

            $accounts = Account::loadByUserId($this->db, $user->getId());
            $this->render('client/transfer', ['accounts' => $accounts]);
        } elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
                $recipient = $_POST['recipient'];
                $sender = $_POST['sender'];

                $amount = $_POST['amount'];
                if(Account::transferFromTo($this->db,$sender, $recipient, $amount)){
                    $this->setFlash('transfer', 'Transfer Completed');
                    header('Location: /transfer');
                    exit;
                }else{
                    $this->setFlash('transfer', 'Transfer not Completed', 'error');
                    header('Location: /transfer');
                    exit;
                }


        }
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
        $this->getMe();
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
        $account = Account::loadById($this->db, $_POST['account_id']);
        if (!$account) {
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
        $account = Account::loadById($this->db, $_POST['account_id']);

        if (!$account) {
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



    private function getMe(){
        $user = Auth::user();
        if (!$user) {
            $this->setFlash('admin_show_client', 'Client not found', 'error');
            header('Location: /admin/clients');
            exit;
        }

        $accounts = Account::loadByUserId($this->db, $user->getId());

        $transactions = [];
        foreach ($accounts as $account) {
            $transaction = new Transaction($this->db);
            $transactions[$account->getId()] = $transaction->getHistory($account->getId());
        }
        return $this->render('client/history', [
            'client' => $user,
            'accounts' => $accounts,
            'transactions' => $transactions
        ]);
    }

}
