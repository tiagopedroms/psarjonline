<?php

namespace App\Lib;

use App\Models\Usuario;
use App\Lib\Audit;

class Auth
{
    public static function startSession(): void
    {
        $config = Db::loadConfig();
        if (session_status() === PHP_SESSION_NONE) {
            session_name($config['session_name'] ?? 'psarj_session');
            session_start();
        }
    }

    public static function check(): bool
    {
        self::startSession();
        return isset($_SESSION['user_id']);
    }

    public static function user(): ?array
    {
        self::startSession();
        return $_SESSION['user'] ?? null;
    }

    public static function attempt(string $email, string $password): bool
    {
        self::startSession();
        $usuarioModel = new Usuario();
        $user = $usuarioModel->findByEmail($email);
        if ($user && $user['ativo'] && password_verify($password, $user['senha_hash'])) {
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['user'] = $user;
            Audit::log((int) $user['id'], 'login', 'usuarios', (int) $user['id'], 'Login bem-sucedido');
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        self::startSession();
        if (isset($_SESSION['user_id'])) {
            Audit::log((int) $_SESSION['user_id'], 'logout', 'usuarios', (int) $_SESSION['user_id'], 'Logout');
        }
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function requireRole(array $perfis): void
    {
        $user = self::user();
        if (!$user || !in_array($user['perfil'], $perfis, true)) {
            http_response_code(403);
            echo 'Acesso negado';
            exit;
        }
    }
}
