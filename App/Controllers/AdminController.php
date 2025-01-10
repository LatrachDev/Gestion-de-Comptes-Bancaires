<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use Helpers\Database;

class AdminController extends BaseController
{
    private $db;
    private $account;

    public function __construct()
    {
        parent::__construct();
        Auth::requireAdmin();
        $this->db = new Database();
        $this->db->connect();
        $this->account = new Account($this->db);
    }

    public function index(): void
    {
        $this->render('admin/index');
    }

    public function showCreateClient()
    {
        $this->render('admin/clients/create');
    }

    public function createClient()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (User::loadByEmail($this->db, $email)) {
            $this->setFlash('admin_create_client', 'Email already exists', 'error');
            header('Location: /admin/clients/create');
            exit;
        }

        $user = User::create($this->db, $name, $email, $password);

        if ($user) {
            $accountCreationSuccess = true;

            if (isset($_POST['create_current'])) {
                $currentDeposit = floatval($_POST['current_deposit'] ?? 0);
                $accountCreated = Account::create(
                    $this->db,
                    $user->getId(),
                    'current',
                    $currentDeposit
                );

                if (!$accountCreated) {
                    $accountCreationSuccess = false;
                    $this->setFlash('admin_create_client', 'Failed to create current account', 'error');
                    header('Location: /admin/clients/create');
                    exit;
                }
            }

            if (isset($_POST['create_savings'])) {
                $savingsDeposit = floatval($_POST['savings_deposit'] ?? 0);
                $accountCreated = Account::create(
                    $this->db,
                    $user->getId(),
                    'savings',
                    $savingsDeposit
                );

                if (!$accountCreated) {
                    $accountCreationSuccess = false;
                    $this->setFlash('admin_create_client', 'Failed to create savings account', 'error');
                    header('Location: /admin/clients/create');
                    exit;
                }
            }

            if ($accountCreationSuccess) {
                $this->setFlash('admin_create_client', 'Client created successfully', 'success');
                header('Location: /admin/clients');
                exit;
            }
        }

        $this->setFlash('admin_create_client', 'Failed to create client', 'error');
        header('Location: /admin/clients/create');
        exit;
    }

    public function listClients()
    {
        $clients = User::loadAllClients($this->db);
        $this->render('admin/clients/index', ['clients' => $clients]);
    }

    public function getClient($id)
    {
        $client = User::loadById($this->db, $id);
        if (!$client) {
            $this->setFlash('admin_show_client', 'Client not found', 'error');
            header('Location: /admin/clients');
            exit;
        }

        $accounts = Account::loadByUserId($this->db, $id);
        
        // Get transactions for each account
        $transactions = [];
        foreach ($accounts as $account) {
            $transaction = new Transaction($this->db);
            $transactions[$account->getId()] = $transaction->getHistory($account->getId());
        }

        return $this->render('admin/clients/show', [
            'client' => $client,
            'accounts' => $accounts,
            'transactions' => $transactions
        ]);
    }

    public function createBankAccount($clientId)
    {
        $client = User::loadById($this->db, $clientId);
        if (!$client) {
            $this->setFlash('admin_show_client', 'Client not found', 'error');
            header('Location: /admin/clients');
            exit;
        }

        $accounts = Account::loadByUserId($this->db, $clientId);
        if (count($accounts) >= 2) {
            $this->setFlash('admin_show_client', 'Client already has maximum number of accounts', 'error');
            header("Location: /admin/clients/{$clientId}");
            exit;
        }

        $existingAccountTypes = array_map(function($account) {
            return $account->getAccountType();
        }, $accounts);

        $accountType = $_POST['account_type'] ?? '';
        if (in_array($accountType, $existingAccountTypes)) {
            $this->setFlash('admin_show_client', 'Client already has a ' . $accountType . ' account', 'error');
            header("Location: /admin/clients/{$clientId}");
            exit;
        }

        $deposit = floatval($_POST['deposit'] ?? 0);
        $accountCreated = Account::create(
            $this->db,
            $clientId,
            $accountType,
            $deposit
        );

        if ($accountCreated) {
            $this->setFlash('admin_show_client', 'Account created successfully', 'success');
        } else {
            $this->setFlash('admin_show_client', 'Failed to create account', 'error');
        }

        header("Location: /admin/clients/{$clientId}");
        exit;
    }

    public function suspendAccount($clientId, $accountId)
    {
        $account = new Account($this->db);
        if ($account->loadById($accountId)) {
            if ($account->suspend()) {
                $this->setFlash('admin_show_client', 'Account suspended successfully', 'success');
            } else {
                $this->setFlash('admin_show_client', 'Failed to suspend account', 'error');
            }
        } else {
            $this->setFlash('admin_show_client', 'Account not found', 'error');
        }
        header("Location: /admin/clients/{$clientId}");
        exit;
    }

    public function activateAccount($clientId, $accountId)
    {
        $account = new Account($this->db);
        if ($account->loadById($accountId)) {
            if ($account->activate()) {
                $this->setFlash('admin_show_client', 'Account activated successfully', 'success');
            } else {
                $this->setFlash('admin_show_client', 'Failed to activate account', 'error');
            }
        } else {
            $this->setFlash('admin_show_client', 'Account not found', 'error');
        }
        header("Location: /admin/clients/{$clientId}");
        exit;
    }

    public function suspendClient($clientId)
    {
        $client = User::loadById($this->db, $clientId);
        if (!$client) {
            $this->setFlash('admin_show_client', 'Client not found', 'error');
            header('Location: /admin/clients');
            exit;
        }

        if ($client->suspend()) {
            // Also suspend all client's accounts
            $accounts = Account::loadByUserId($this->db, $clientId);
            foreach ($accounts as $account) {
                $account->suspend();
            }
            $this->setFlash('admin_show_client', 'Client suspended successfully', 'success');
        } else {
            $this->setFlash('admin_show_client', 'Failed to suspend client', 'error');
        }

        header("Location: /admin/clients/{$clientId}");
        exit;
    }

    public function activateClient($clientId)
    {
        $client = User::loadById($this->db, $clientId);
        if (!$client) {
            $this->setFlash('admin_show_client', 'Client not found', 'error');
            header('Location: /admin/clients');
            exit;
        }

        if ($client->activate()) {
            // Also activate all client's accounts
            $accounts = Account::loadByUserId($this->db, $clientId);
            foreach ($accounts as $account) {
                $account->activate();
            }
            $this->setFlash('admin_show_client', 'Client activated successfully', 'success');
        } else {
            $this->setFlash('admin_show_client', 'Failed to activate client', 'error');
        }

        header("Location: /admin/clients/{$clientId}");
        exit;
    }
}
