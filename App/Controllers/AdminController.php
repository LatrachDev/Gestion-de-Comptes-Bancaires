<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\User;
use App\Models\Account;
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

            if (isset($_POST['create_current'])) {
                $currentDeposit = floatval($_POST['current_deposit'] ?? 0);
                $accountsCreated = Account::create(
                    $this->db,
                    $user->getId(),
                    'current',
                    $currentDeposit
                );

                if (!$accountsCreated) {
                    $this->setFlash('admin_create_client', 'Failed to create current account', 'error');
                    header('Location: /admin/clients/create');
                    exit;
                }
            }

            if (isset($_POST['create_savings'])) {
                $savingsDeposit = floatval($_POST['savings_deposit'] ?? 0);
                $accountsCreated = Account::create(
                    $this->db,
                    $user->getId(),
                    'savings',
                    $savingsDeposit
                );

                if (!$accountsCreated) {
                    $this->setFlash('admin_create_client', 'Failed to create savings account', 'error');
                    header('Location: /admin/clients/create');
                    exit;
                }
            }

            if ($accountsCreated) {
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

        $accounts = Account::loadByUserId($this->db, $client->getId());
        $this->render('admin/clients/show', [
            'client' => $client,
            'accounts' => $accounts
        ]);
    }
}
