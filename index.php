<!doctype html>
<html lang="pl">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Card Game - Vanilla JS</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./src/css/main.css"/>
  <link rel="icon" type="image/x-icon" href="./assets/favicon.ico">
</head>

<body>
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
        <?php require __DIR__ . '/auth/session.php'; ?>
        <?php if (is_logged_in()): ?>
          <li class="menu__item">
            <span
              class="menu__link">Witaj, <?= htmlspecialchars($_SESSION['user_email'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
          </li>
          <li class="menu__item"><a class="menu__link" href="/auth/logout.php">Wyloguj</a></li>
        <?php else: ?>
          <li class="menu__item"><a class="menu__link" href="/auth/login.php">Logowanie</a></li>
          <li class="menu__item"><a class="menu__link" href="/auth/register.php">Rejestracja</a></li>
        <?php endif; ?>
    </ul>
  </nav>
  <header class="header">
    <img class="header__logo" src="./assets/logo.png" alt="logo" width="50">
    <h1 class="header__heading">Gra w oczko</h1>
  </header>

  <main class="game">
    <section class="match">
      <div class="match__result">
        <span class="match__result-text">Wynik</span>
        <span class="match__result-player">0</span>
        <span class="match__result-text">:</span>
        <span class="match__result-computer">0</span>
      </div>
    </section>
    <section class="player">
      <h2 class="heading">Gracz</h2>
      <div class="player__score">
        Punkty: <span class="player__score-value">0</span>
      </div>
      <div class="player__hand"></div>
      <div class="player__buttons">
        <button class="btn giveCard" disabled>Daj kartę</button>
        <button class="btn stopCard" disabled>Stop</button>
      </div>
    </section>
    <section class="computer">
      <h2 class="heading">Komputer</h2>
      <div class="computer__score">
        Punkty: <span class="computer__score-value">0</span>
      </div>
      <div class="computer__hand"></div>
    </section>

    <section class="deck">
      <div class="deck__buttons">
        <button class="btn start">Start</button>
        <button class="btn reset" disabled>Reset</button>
      </div>
    </section>
  </main>

  <script type="module" src="./src/js/index.js"></script>
  <script src="./src/js/navigate.js"></script>
</body>
</html>
