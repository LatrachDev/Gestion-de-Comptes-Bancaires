<?php

namespace Core;

use Core\Auth;

class BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = new Auth();
    }

    protected function render(string $view, array $data = []): void
    {
        // Add auth data to all views
        $data['auth'] = [
            'check' => Auth::check(),
            'user' => Auth::user(),
            'isAdmin' => Auth::isAdmin()
        ];

        $viewPath = "../App/Views/{$view}.php";
        if (file_exists($viewPath)) {
            extract($data);
            require $viewPath;
        } else {
            die("View {$view} not found");
        }
    }

    public function setFlash($flashName, $message, $type = 'success'): void
    {
        $_SESSION[$flashName] = [
            'message' => $message,
            'type' => $type
        ];
    }

    public function getFlash($flashName): ?array
    {
        if (isset($_SESSION[$flashName])) {
            $flash = $_SESSION[$flashName];
            unset($_SESSION[$flashName]);
            return $flash;
        }
        return null;
    }

    public function hasFlash($flashName): bool
    {
        return isset($_SESSION[$flashName]);
    }
}
