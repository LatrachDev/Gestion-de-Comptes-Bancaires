<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Auth;
use App\Models\User;
use Helpers\Database;

class AuthController extends BaseController
{
    private $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = new Database();
        $this->db->connect();
    }

    public function login()
    {
        if (Auth::check()) {
            header('Location: ' . (Auth::isAdmin() ? '/admin' : '/dashboard'));
            exit;
        }
        $this->render('auth/login');
    }

    public function handleLogin()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = User::loadByEmail($this->db, $email);
        
        if ($user){
            $success = false;

            if ($user->verifyPassword($password)) {
                $success = true;
            } else {
                $this->setFlash('loginError', 'Invalid credentials', 'error');
                header('Location: /login');
                exit;
            }
            if ($user->isActive()){
                $success = true;
            } else {
                $this->setFlash('loginError', 'Your account is blocked', 'error');
                header('Location: /login');
                exit;
            }
            if ($success) {
                Auth::login($user); 
            }
        } else{
            $this->setFlash('loginError', 'User not found', 'error');
            header('Location: /login');
            exit;
        }

        

        
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /login');
        exit;
    }
}
