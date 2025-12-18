<?php
define("BASE_DIR", dirname(__DIR__));

require_once BASE_DIR . '/config/env_loader.php';

load_env(BASE_DIR . '/config/.env');

spl_autoload_register(function (string $class) {
  $prefix = 'App\\';
   $class = str_replace($prefix, '', $class);
   $file = BASE_DIR . '/src/' . str_replace('\\', '/', $class) . '.php';
   if (file_exists($file)) {
       require_once $file;
   }
});
