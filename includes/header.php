<nav class="nav">
  <button class="hamburger">
    <span class="hamburger__line"></span>
    <span class="hamburger__line"></span>
    <span class="hamburger__line"></span>
  </button>
  <ul class="menu inactive">
    <li class="menu__item"><a class="menu__link" href="/">Strona główna</a></li>
    <li class="menu__item"><a class="menu__link" href="/about">O mnie</a></li>
    <li class="menu__item"><a class="menu__link" href="/contact">Kontakt</a></li>
      <?php require_once __DIR__ . '/../auth/session.php'; ?>
      <?php if (is_logged_in()): ?>
        <li class="menu__item" id="user">
            <span class="menu__link">
              Witaj,
                <?= htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>
            </span>
        </li>
        <li class="menu__item"><a class="menu__link" href="/auth/logout.php">Wyloguj</a></li>
      <?php else: ?>
        <li class="menu__item"><a class="menu__link" href="/auth/login.php">Logowanie</a></li>
        <li class="menu__item"><a class="menu__link" href="/auth/register.php">Rejestracja</a></li>
      <?php endif; ?>
  </ul>
</nav>
<header class="header">
  <img class="header__logo" src="/assets/logo.png" alt="logo" width="50">
  <h1 class="header__heading">Gra w oczko</h1>
</header>
