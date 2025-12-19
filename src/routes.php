<?php

use App\Controller;

return [
  'GET' => [
    '/' => 'index',
    '/login' => 'login',
    '/register' => 'register',
    '/logout' => 'logout',
  ],
  'POST' => [
    '/login' => 'processLogin',
    '/register' =>  'processRegister',
  ],
];

