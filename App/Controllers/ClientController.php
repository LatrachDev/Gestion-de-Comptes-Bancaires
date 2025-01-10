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

    // public function updateProfile(): void
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $user = Auth::user();

    //         // Retrieve form data
    //         $name = trim($_POST['name']);
    //         $email = trim($_POST['email']);
    //         $currentPassword = $_POST['current_password'] ?? '';
    //         $newPassword = $_POST['new_password'] ?? '';
    //         $confirmPassword = $_POST['confirm_password'] ?? '';

    //         // Basic validation
    //         if (empty($name) || empty($email)) {
    //             $_SESSION['error'] = 'Name and email cannot be empty.';
    //             header('Location: /profile');
    //             exit;
    //         }

    //         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $_SESSION['error'] = 'Invalid email format.';
    //             header('Location: /profile');
    //             exit;
    //         }

    //         // Password update logic
    //         $hashedPassword = $user->getPassword(); // Default to current password

    //         if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
    //             if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
    //                 $_SESSION['error'] = 'All password fields are required.';
    //                 header('Location: /profile');
    //                 exit;
    //             }

    //             if (!password_verify($currentPassword, $hashedPassword)) {
    //                 $_SESSION['error'] = 'Current password is incorrect.';
    //                 header('Location: /profile');
    //                 exit;
    //             }

    //             if ($newPassword !== $confirmPassword) {
    //                 $_SESSION['error'] = 'New passwords do not match.';
    //                 header('Location: /profile');
    //                 exit;
    //             }

    //             $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    //         }

    //         // Update database
    //         try {
    //             $this->db->query(
    //                 "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id",
    //                 [
    //                     ':name' => $name,
    //                     ':email' => $email,
    //                     ':password' => $hashedPassword,
    //                     ':id' => $user->getId(),
    //                 ]
    //             );

    //             // Update user object in session
    //             $user->setName($name);
    //             $user->setEmail($email);
    //             $_SESSION['user'] = $user;

    //             $_SESSION['success'] = 'Profile updated successfully.';
    //             header('Location: /profile');
    //             exit;
    //         } catch (\Exception $e) {
    //             $_SESSION['error'] = 'Failed to update profile. Please try again later.';
    //             header('Location: /profile');
    //             exit;
    //         }
    //     }

    //     header('Location: /profile');
    //     exit;
    // }

    
    
}


