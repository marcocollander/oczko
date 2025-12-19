<?php
declare(strict_types=1);

namespace App;

class Router
{

  private array $routes = [];

  public function __construct ()
  {
    $this->loadRoutes (require __DIR__ . '/routes.php');
  }

  private function loadRoutes (array $routes): void
  {
    $this->routes = $routes;
  }


  public function resolve (): void
  {
    $path = Request::getPath ();
    $method = Request::getMethod ();

    $controlers = new Controller();

    if (array_key_exists ($method, $this->routes) && array_key_exists ($path, $this->routes[$method])) {
      $controlers->{$this->routes[$method][$path]}();
    } else {
      http_response_code (404);
      echo "404 Not Found - Strona nie istnieje.";
    }
  }
}
