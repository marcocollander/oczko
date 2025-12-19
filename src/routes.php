<?php

use App\Controller;

$routes = [
  'GET' => [
    '/' => [Controller::class, 'index'],
    '/login' => [Controller::class, 'login'],
    '/register' => [Controller::class, 'register'],
    '/logout' => [Controller::class, 'logout'],
  ],
  'POST' => [
    '/login' => [Controller::class, 'login'],
    '/register' => [Controller::class, 'register'],
  ],
];
