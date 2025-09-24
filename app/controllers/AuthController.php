<?php

namespace App\Controllers;

use App\Lib\Auth;
use App\Lib\Csrf;
use App\Lib\RateLimiter;
use App\Lib\Utils;

class AuthController extends BaseController
{
    protected bool $requiresAuth = false;

    public function login(): void
    {
        if (Auth::check()) {
            Utils::redirect('dashboard/index');
        }

        $this->view('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function authenticate(): void
    {
        if (!RateLimiter::allow('login_' . ($_SERVER['REMOTE_ADDR'] ?? 'cli'))) {
            $this->view('auth/login', [
                'title' => 'Login',
                'error' => 'Muitas tentativas. Aguarde um momento.'
            ]);
            return;
        }

        Csrf::validate($_POST['_token'] ?? null);

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (Auth::attempt($email, $password)) {
            Utils::redirect('dashboard/index');
            return;
        }

        $this->view('auth/login', [
            'title' => 'Login',
            'error' => 'Credenciais inválidas'
        ]);
    }

    public function logout(): void
    {
        Auth::logout();
        Utils::redirect('auth/login');
    }
}
