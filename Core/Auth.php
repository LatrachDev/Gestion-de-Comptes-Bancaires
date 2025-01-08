<?php

namespace Core;

use App\Models\User;
use Helpers\Database;
class Auth
{
    private static $user = null;

    public static function login(User $user)
    {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_role'] = $user->getRole();
        self::$user = $user;
        die;
    }

    public static function logout()
    {
        $_SESSION = array();
        session_destroy();
        self::$user = null;
    }

    public static function user()
    {
        if (self::$user === null && isset($_SESSION['user_id'])) {
            $db = new Database();
            $db->connect();
            self::$user = User::loadById($db, $_SESSION['user_id']);
        }
        return self::$user;
    }

    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin()
    {
        return self::check() && $_SESSION['user_role'] === 'admin';
    }

    public static function require()
    {
        if (!self::check()) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireAdmin()
    {
        if (!self::isAdmin()) {
            header('Location: /login');
            exit;
        }
    }
}
