<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)); // katalog główny projektu
$dotenv->safeLoad(); // nie rzuci wyjątku, jeśli brak .env

$DB_HOST = $_ENV['APP_DB_HOST'] ?? '127.0.0.1';
$DB_NAME = $_ENV['APP_DB_NAME'] ?? 'oczko';
$DB_USER = $_ENV['APP_DB_USER'] ?? 'root';
$DB_PASS = $_ENV['APP_DB_PASS'] ?? '';

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Błąd bazy danych.';
    exit;
}