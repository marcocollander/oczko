<?php
declare(strict_types=1);

require __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

if (!is_logged_in()) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'unauthorized']);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'method_not_allowed']);
    exit;
}

$raw = file_get_contents('php://input') ?: '';
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'invalid_json']);
    exit;
}

$matches = $data['number_of_matches'] ?? null;
$wins = $data['number_of_wins'] ?? null;

if (!is_int($matches) || !is_int($wins) || $matches < 0 || $wins < 0) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'invalid_payload']);
    exit;
}

$userId = (int)$_SESSION['user_id'];

try {
    $stmt = $pdo->prepare('UPDATE users SET number_of_matches = ?, number_of_wins = ? WHERE id = ?');
    $stmt->execute([$matches, $wins, $userId]);
    echo json_encode(['ok' => true]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'db_error']);
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
