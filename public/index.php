<?php
session_start();

// CSRF-token aanmaken
if (empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

// Meldingen ophalen
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? null;
unset($_SESSION['errors'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Vista College</title>
  <link rel="stylesheet" href="../assets/css/style.css"/>
</head>
<body>
  <!-- Linker foto -->
  <div class="left-container">
    <div class="bg"></div>
  </div>

  <!-- Rechter paneel -->
  <div class="right-panel">
    <div class="content">
      <!-- Vista-logo -->
      <div class="logo-circle">
        <img src="../assets/images/vista-logo.png" alt="Vista College logo" />
      </div>

      <!-- Alerts -->
      <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
          <?= implode('<br>', array_map('htmlspecialchars', $errors)) ?>
        </div>
      <?php elseif (!empty($success)): ?>
        <div class="alert alert-success">
          <?= htmlspecialchars($success) ?>
        </div>
      <?php endif; ?>

      <!-- Auth container -->
      <div id="auth-container" class="auth register-active">

        <!-- Titels -->
        <h1 class="title register-title">Maak een account</h1>
        <h1 class="title login-title">Log in</h1>

        <!-- Microsoft knop -->
        <a href="#" class="btn oauth-btn" title="Login met Vista">
          <img src="../assets/images/microsoft-logo.png" alt="Microsoft logo" class="microsoft-logo" />
          <span>Doorgaan met Vista</span>
        </a>

        <div class="divider">
          <span class="line"></span>
          <span class="or">of</span>
          <span class="line"></span>
        </div>

        <!-- Registratieformulier -->
        <form class="form register-form" method="post" action="../handlers/register.php">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

          <label class="field">
            <span class="label">E-mailadres</span>
            <input type="email" name="email" placeholder="Voer je e-mailadres in" required />
          </label>

          <label class="field">
            <span class="label">Volledige naam</span>
            <input type="text" name="fullname" placeholder="Voor- en achternaam" required />
          </label>

          <label class="field">
            <span class="label">Wachtwoord</span>
            <input type="password" name="password" placeholder="Voer een wachtwoord in" minlength="8" required />
          </label>

          <button class="btn submit" type="submit">Maak een account aan</button>

          <p class="meta">Al een account? <a href="#" id="switch-to-login">Log in</a></p>
        </form>

        <!-- Loginformulier -->
        <form class="form login-form" method="post" action="../handlers/login.php">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

          <label class="field">
            <span class="label">E-mailadres</span>
            <input type="email" name="email" placeholder="Voer je e-mailadres in" required />
          </label>

          <label class="field">
            <span class="label">Wachtwoord</span>
            <input type="password" name="password" placeholder="Voer je wachtwoord in" required />
          </label>

          <button class="btn submit" type="submit">Log in</button>

          <p class="meta">Nog geen account? <a href="#" id="switch-to-register">Maak er één aan</a></p>
        </form>

      </div>
    </div>
  </div>

  <script>
    // Wissel tussen login en registratie
    const container = document.getElementById('auth-container');
    const toLogin = document.getElementById('switch-to-login');
    const toRegister = document.getElementById('switch-to-register');

    toLogin.addEventListener('click', (e) => {
      e.preventDefault();
      container.classList.remove('register-active');
      container.classList.add('login-active');
    });

    toRegister.addEventListener('click', (e) => {
      e.preventDefault();
      container.classList.remove('login-active');
      container.classList.add('register-active');
    });

    // Meldingen automatisch verwijderen na 4s
    setTimeout(() => {
      document.querySelectorAll('.alert').forEach(a => {
        a.style.transition = 'opacity .4s ease';
        a.style.opacity = '0';
        setTimeout(() => a.remove(), 400);
      });
    }, 4000);
  </script>
</body>
</html>
