<?php
declare(strict_types=1);

global $pdo;
require __DIR__ . '/../config/config.php';
require_once __DIR__ . '/session.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    $password2 = (string)($_POST['repeat-password'] ?? '');
    $username = (string)($_POST['username'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Nieprawidłowy e-mail.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Hasło musi mieć co najmniej 8 znaków.';
    }
    if ($password !== $password2) {
        $errors[] = 'Hasła nie są zgodne.';
    }

    if (!$errors) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = 'Użytkownik z tym e-mailem już istnieje.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = $pdo->prepare('INSERT INTO users (email, password_hash, username) VALUES (?, ?, ?)');
            $ins->execute([$email, $hash, $username]);
            $success = true;
        }
    }
}
?>

<!doctype html>
<html lang="pl">
<?php require __DIR__ . '/../includes/head.php'; ?>
<body>
    <?php require __DIR__ . '/../includes/header.php'; ?>
  <h1 class="heading heading--auth">Rejestracja</h1>

    <?php if ($success): ?>
      <p>Konto utworzone. <a href="/auth/login.php">Zaloguj się</a>.</p>
    <?php else: ?>
        <?php foreach ($errors as $e): ?>
        <p style="color:red"><?= htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <?php endforeach; ?>

      <form class="form" action="/auth/register.php" method="POST">
        <div class="form__field">
          <label class="form__label" for="username">Imię:</label>
          <input class="form__control" type="text" id="username" name="username" required>
        </div>
        <div class="form__field">
          <label class="form__label" for="email">Email:</label>
          <input class="form__control" type="email" id="email" name="email" required>
        </div>
        <div class="form__field">
          <label class="form__label" for="password">Hasło:</label>
          <input class="form__control" type="password" id="password" name="password" required>
        </div>
        <div class="form__field">
          <label class="form__label" for="repeat-password">Powtórz hasło:</label>
          <input class="form__control" type="password" id="repeat-password" name="repeat-password" required>
        </div>
        <div class="form__field">
          <button class="form__btn" type="submit">Zarejestruj się</button>
        </div>
      </form>


    <?php endif; ?>
    <?php require __DIR__ . '/../includes/scripts.php'; ?>
  <?php require __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>

