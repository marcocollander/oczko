<?php

declare(strict_types=1);

namespace App;

use Random\RandomException;

class Auth
{
  public static function startSession(): void
  {
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
      ]);
      session_start();
    }
  }

  public static function isLoggedIn(): bool
  {
    self::startSession();
    return isset($_SESSION['user_id']) && is_int($_SESSION['user_id']);
  }

  // simple CSRF helpers

  /**
   * @throws RandomException
   */
  public static function generateCsrfToken(): string
  {
    self::startSession();
    if (empty($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
  }

  public static function checkCsrfToken(?string $token): bool
  {
    self::startSession();
    if (empty($token) || empty($_SESSION['csrf_token'])) {
      return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
  }

  public static function logout_clean(): void
  {
    self::startSession();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
  }
}
