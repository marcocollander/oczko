<?php
declare(strict_types=1);

namespace App;

class Router
{

  private array $routes = [];

  public function addRoute(string $method, string $path, array $handler): void
  {
    $this->routes[] = [
      'method' => $method,
      'path' => $path,
      'handler' => $handler
    ];
  }

  public function resolve(): void
  {
    $path = Request::getPath();
    $method = Request::getMethod();

    foreach ($this->routes as $route) {
      if ($route['path'] === $path && $route['method'] === $method){
        $handler = $route['handler'];

        if (is_array($handler)) {
          [ $controllerClass, $action ] = $handler;
          $controller = new $controllerClass();
          $controller->$action();
        } else {
          $handler();
        }
        return;
      }

    }
    http_response_code(404);
    echo "404 Not Found - Strona nie istnieje.";
  }
}
