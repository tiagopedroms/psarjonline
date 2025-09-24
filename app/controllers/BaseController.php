<?php

namespace App\Controllers;

use App\Lib\Auth;
use App\Lib\Utils;
use App\Models\Permissao;

abstract class BaseController
{
    protected bool $requiresAuth = true;
    protected array $publicActions = [];
    protected ?Permissao $permissao = null;

    public function __construct()
    {
        $route = $_GET['route'] ?? '';
        [, $action] = array_pad(explode('/', $route), 2, 'index');
        if ($this->requiresAuth && !in_array($action, $this->publicActions, true) && !Auth::check()) {
            Utils::redirect('auth/login');
        }
        $this->permissao = new Permissao();
    }

    protected function view(string $view, array $data = []): void
    {
        Utils::view($view, $data);
    }

    protected function authorize(string $modulo, string $acao): void
    {
        $user = Auth::user();
        if (!$user) {
            Utils::redirect('auth/login');
        }
        if ($user['perfil'] === 'Administrador') {
            return;
        }
        if (!$this->permissao->verifica($user['perfil'], $modulo, $acao)) {
            http_response_code(403);
            echo 'Acesso negado';
            exit;
        }
    }
}
