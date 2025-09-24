<?php

use App\Controllers\AdminController;
use App\Controllers\AgendaController;
use App\Controllers\AuthController;
use App\Controllers\CatequeseController;
use App\Controllers\CmsController;
use App\Controllers\DashboardController;
use App\Controllers\FinanceiroController;
use App\Controllers\IntencoesController;
use App\Controllers\PessoasController;
use App\Controllers\SacramentosController;
use App\Lib\Auth;
use App\Lib\Router;

require __DIR__ . '/../vendor/autoload.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    if (strpos($class, $prefix) === 0) {
        $path = __DIR__ . '/../' . str_replace('App\\', 'app/', $class) . '.php';
        $path = str_replace('\\', '/', $path);
        if (file_exists($path)) {
            require $path;
        }
    }
});

Auth::startSession();

$route = $_GET['route'] ?? 'dashboard/index';
[$controllerName, $action] = array_pad(explode('/', $route), 2, 'index');
$controllerClass = 'App\\Controllers\\' . ucfirst($controllerName) . 'Controller';

if (!class_exists($controllerClass)) {
    http_response_code(404);
    echo 'Controller não encontrado';
    exit;
}

$controller = new $controllerClass();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo 'Ação não encontrada';
    exit;
}

$controller->{$action}();
