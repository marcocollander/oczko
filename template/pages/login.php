<?php global$errors; ?>
  <h1 class="heading heading--auth">Logowanie</h1>

    <?php foreach ($errors as $e): ?>
      <p style="color:red"><?= htmlspecialchars($e, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endforeach; ?>

  <form class="form" action="/login" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf ?? '', ENT_QUOTES); ?>">
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
      <a href="/register">Zarejestruj się</a>
    </div>

