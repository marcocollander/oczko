<?php

declare(strict_types=1);

namespace App;

class Request
{
  public static function getPath(): string
  {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH) ?? '/';
    $path = rtrim($path, '/');
    return $path === '' ? '/' : $path;
  }

  public static function getMethod(): string
  {
    return $_SERVER['REQUEST_METHOD'] ?? 'GET';
  }

  public static function get(string $key, $default = null)
  {
    return $_GET[$key] ?? $default;
  }

  public static function post(string $key, $default = null)
  {
    return $_POST[$key] ?? $default;
  }
}
