<?php

namespace App\Lib;

class Csrf
{
    public static function token(): string
    {
        Auth::startSession();
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    public static function input(): string
    {
        return '<input type="hidden" name="_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES) . '">';
    }

    public static function validate(?string $token): bool
    {
        Auth::startSession();
        $valid = isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], (string) $token);
        if (!$valid) {
            http_response_code(419);
            echo 'Token CSRF inválido';
            exit;
        }
        return true;
    }
}
