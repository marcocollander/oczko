<?php
declare(strict_types=1);
require __DIR__ . '/../config/config.php';
require __DIR__ . '/session.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        // Nie zdradzamy, czy e-mail istnieje
        $errors[] = 'Nieprawidłowy e-mail lub hasło.';
    } else {
        // Regeneracja ID sesji po logowaniu (ochrona przed session fixation)
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['user_email'] = $email;

        $next = $_GET['next'] ?? '/';
        // Zapobieganie open redirect
        if (!is_string($next) || str_starts_with($next, 'http')) {
            $next = '/';
        }
        header('Location: ' . $next);
        exit;
    }
}
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Logowanie</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Logowanie</h1>

    <?php foreach ($errors as $e): ?>
        <p style="color:red"><?= htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endforeach; ?>

    <form method="post" action="/auth/login.php" novalidate>
        <label>Email
            <input type="email" name="email" required autocomplete="username">
        </label><br>
        <label>Hasło
            <input type="password" name="password" required autocomplete="current-password">
        </label><br>
        <button type="submit">Zaloguj</button>
    </form>

    <p>Nie masz konta? <a href="/auth/register.php">Zarejestruj się</a></p>
</body>
</html>

