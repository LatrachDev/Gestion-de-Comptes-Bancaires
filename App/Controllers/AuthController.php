<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;
use Core\Auth;
use Helpers\Database;

class AuthController extends BaseController
{
    private $db;

    public function __construct()
    {
        // parent::__construct();
        $this->db = new Database();
        $this->db->connect();
    }

    public function login()
    {
        if (Auth::check()) {
            header('Location: /index');
            exit;
        }
        $this->render('auth/login');
    }

    public function handleLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::loadByEmail($this->db, $email);

        if ($user && $user->verifyPassword($password)) {
            Auth::login($user);
            header('Location: ' . ($user->getRole() === 'admin' ? '/admin' : '/'));
            exit;
        } else {
            $this->setFlash('loginError', 'wrong email or password', 'error');
            $this->login();
        }
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /login');
        exit;
    }
}