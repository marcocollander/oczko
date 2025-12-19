<?php

declare(strict_types=1);

namespace App;

use AllowDynamicProperties;
use PDO;
use PDOException;

#[AllowDynamicProperties]
class Database
{
  private PDO $pdo;
  public static array$error = [];

  public function __construct()
  {
       $this->config = include __DIR__ . '/../config/config.php';
       $this->connect();
  }

  public function register(): void
  {
    Auth::startSession();

    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $password2 = (string)($_POST['repeat-password'] ?? '');
    $username = trim((string)($_POST['username'] ?? ''));
    $csrf = (string)($_POST['csrf_token'] ?? '');

    if (!Auth::checkCsrfToken($csrf)) {
      echo 'Błąd CSRF.';
      exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'Nieprawidłowy format e-mail.';
      exit;
    }

    if (strlen($password) < 8) {
      echo 'Hasło musi mieć co najmniej 8 znaków.';
      exit;
    }

    if ($password !== $password2) {
      echo 'Hasła nie są zgodne.';
      exit;
    }

    if ($username === '') {
      echo 'Podaj nazwę użytkownika.';
      exit;
    }

    // sprawdź istniejący email
    $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
      echo 'Użytkownik z tym e-mailem już istnieje.';
      exit;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $ins = $this->pdo->prepare('INSERT INTO users (email, password_hash, username) VALUES (?, ?, ?)');
    $ins->execute([$email, $hash, $username]);

    echo "Rejestracja zakończona sukcesem. Możesz się teraz zalogować.<br>";
    echo "<a href='/login'>Logowanie</a><br>";
    echo "<a href='/'>Powrót na stronę główną</a>";
  }

  public function login(): void
  {
    Auth::startSession();

    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $csrf = (string)($_POST['csrf_token'] ?? '');

    if (!Auth::checkCsrfToken($csrf)) {
      echo 'Błąd CSRF.';
      exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo 'nieprawidłowy email';
    }

    $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
      echo 'Nieprawidłowy e-mail lub hasło.';
      exit;
    }

    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $user['username'];

    $next = $_GET['next'] ?? '/';
    if (!is_string($next) || ($next === '') || $next[0] !== '/') {
      $next = '/';
    }

    header('Location: ' . $next);
    exit;
  }

  public function logout(): void
  {
    Auth::logout_clean();
    header('Location: /');
    exit;
  }

  private function connect(): void
  {
    $db = $this->config;

    $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4;collation=utf8mb4_polish_ci";

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false
      ];

    try {
      $this->pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
    } catch (PDOException $e) {
      http_response_code(500);
      echo 'Błąd bazy danych.';
      exit;
    }
  }
}
