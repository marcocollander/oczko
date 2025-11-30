 <!doctype html>
<html lang="pl">
<?php require __DIR__ . '/includes/head.php'; ?>

<body>
<?php require __DIR__ . '/includes/header.php'; ?>
    <?php
    global$pdo;
    // Wstrzyknięcie statystyk do JS jeśli zalogowany
    require_once __DIR__ . '/auth/session.php';
    require_once __DIR__ . '/config/config.php';
    $stats = get_current_user_stats($pdo);
    ?>
  <script>
    window.__USER_STATS__ = <?= json_encode($stats, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
  </script>

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

<?php require __DIR__ . '/includes/scripts.php'; ?>
  <?php require __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
