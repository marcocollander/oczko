
  <h1 class="heading heading--auth">Rejestracja</h1>

      <form class="form" action="/register" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf ?? '', ENT_QUOTES); ?>">
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

