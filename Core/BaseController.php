<?php

namespace Core;

class BaseController
{
    public function render($view, $data = []): void
    {
        extract($data);
        require_once base_path('App/Views/' . $view . '.php');
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
        if(isset($_SESSION[$flashName])) {
            $flash = $_SESSION[$flashName];
            unset($_SESSION[$flashName]);
            return $flash;
        }
        return null;
    }
}