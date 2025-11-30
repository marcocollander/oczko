<?php
declare(strict_types=1);

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

function is_logged_in(): bool {
    return isset($_SESSION['user_id']) && is_int($_SESSION['user_id']);
}

// Helper do pobrania statystyk bieżącego użytkownika
function get_current_user_stats(PDO $pdo): array {
    if (!is_logged_in()) {
        return ['number_of_matches' => null, 'number_of_wins' => null];
    }
    $stmt = $pdo->prepare('SELECT number_of_matches, number_of_wins FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([(int)$_SESSION['user_id']]);
    $row = $stmt->fetch() ?: null;
    if (!$row) {
        return ['number_of_matches' => 0, 'number_of_wins' => 0];
    }
    return [
        'number_of_matches' => (int)$row['number_of_matches'],
        'number_of_wins' => (int)$row['number_of_wins'],
    ];
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: /auth/login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/'));
        exit;
    }
}
