<?php
declare(strict_types=1);
use App\Auth;
use App\Controller;
use App\Router;

require_once __DIR__ . '/src/loader.php';

Auth::startSession();

$config = include __DIR__ . '/config/config.php';

$router = new Router();
$router->addRoute('GET', '/', [Controller::class, 'index']);
$router->addRoute('GET', '/login', [Controller::class, 'login']);
$router->addRoute('POST', '/login', [Controller::class, 'login']);
$router->addRoute('GET', '/register', [Controller::class, 'register']);
$router->addRoute('POST', '/register', [Controller::class, 'register']);
$router->addRoute('GET', '/logout', [Controller::class, 'logout']);

try{
  $router->resolve ();
} catch(Exception $e) {
  echo 'Wystąpił błąd' . $e->getMessage();
}


