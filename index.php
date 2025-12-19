<?php
declare(strict_types=1);
use App\Auth;
use App\Controller;
use App\Router;

require_once __DIR__ . '/src/loader.php';
//require_once __DIR__ . '/utils/debug.php';

Auth::startSession();

$config = include __DIR__ . '/config/config.php';

$router = new Router();

try{
  $router->resolve ();
} catch(Exception $e) {
  echo 'Wystąpił błąd' . $e->getMessage();
}


