<?php
declare(strict_types=1);
global $pdo;
require __DIR__ . '/../config/config.php';
require_once __DIR__ . '/session.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string)($_POST['email'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    $stmt = $pdo->prepare('SELECT id, password_hash, username FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        // Nie zdradzamy, czy e-mail istnieje
        $errors[] = 'Nieprawidłowy e-mail lub hasło.';
    } else {
        // Regeneracja ID sesji po logowaniu (ochrona przed session fixation)
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $user['username'];


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
<?php require __DIR__ . '/../includes/head.php'; ?>
<body>
    <?php require __DIR__ . '/../includes/header.php'; ?>
  <h1 class="heading heading--auth">Logowanie</h1>

    <?php foreach ($errors as $e): ?>
      <p style="color:red"><?= htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endforeach; ?>

  <form class="form"
        action="/auth/login.php<?php if (isset($_GET['next'])): ?>?next=<?= urlencode((string)$_GET['next']) ?><?php endif; ?>"
        method="POST">
    <div class="form__field">
      <label class="form__label" for="email">Email:</label>
      <input class="form__control" type="email" id="email" name="email" required>
    </div>
    <div class="form__field">
      <label class="form__label" for="password">Hasło:</label>
      <input class="form__control" type="password" id="password" name="password" required>
    </div>
    <div class="form__field">
      <button class="form__btn" type="submit">Zaloguj się</button>
    </div>
    <div class="form__field">
      <p class="form__info">Nie masz konta? </p>
      <a href="/auth/register.php">Zarejestruj się</a>
    </div>

      <?php require __DIR__ . '/../includes/scripts.php'; ?>
  </form>

  <?php require __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>

