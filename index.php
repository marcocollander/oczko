<?php
declare(strict_types=1);
use App\Auth;
use App\Controller;

require_once __DIR__ . '/src/loader.php';

Auth::startSession();

$config = include __DIR__ . '/config/config.php';

$controler = new Controller();
try {
  $controler->run();
} catch (\Random\RandomException $e) {
  echo $e->getMessage();
}



