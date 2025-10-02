<?php
// Optioneel: simpele flash via querystring (?ok=1 of ?error=...)
$ok = isset($_GET['ok']);
$error = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : '';
?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Maak een account</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
  <div class="split">
    <!-- LEFT: hero image + overlay text -->
    <aside class="hero">
      <!-- Gebruik je eigen foto hier; Unsplash als placeholder -->
      <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?q=80&w=1600&auto=format&fit=crop" alt="Students collaborating" />
      <div class="hero-overlay">
        <div class="brand">
          <!-- Simpele “VISTA” lockup als placeholder (SVG) -->
          <svg viewBox="0 0 420 100" class="logo">
            <text x="0" y="70" font-size="72" font-family="Inter, system-ui" font-weight="800" letter-spacing="6">V I S T A</text>
          </svg>
          <div class="sub">college</div>
        </div>

        <h1>Jouw magazijn.</h1>
        <p class="subtitle">Jouw controle.</p>
      </div>
    </aside>

    <!-- RIGHT: form card -->
    <main class="panel">
      <div class="card">
        <div class="avatar">
          <div class="circle">
            <!-- avatar icon -->
            <svg viewBox="0 0 24 24" aria-hidden="true">
              <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5A1.5 1.5 0 0 0 4.5 21h15a1.5 1.5 0 0 0 1.5-1.5C21 16.5 17 14 12 14Z"/>
            </svg>
          </div>
        </div>

        <h2>Maak een account</h2>

        <button type="button" class="sso-btn" id="ssoBtn">
          <span class="sso-icon" aria-hidden="true">🔷</span>
          Maak een account met Vista
        </button>

        <div class="divider">
          <span></span>
          <em>of</em>
          <span></span>
        </div>

        <?php if ($ok): ?>
          <div class="alert success">Account aangemaakt! Je kunt nu inloggen.</div>
        <?php elseif ($error): ?>
          <div class="alert error"><?= $error ?></div>
        <?php endif; ?>

        <form id="signupForm" action="process.php" method="post" novalidate>
          <label class="field">
            <span>E-mailadres</span>
            <input type="email" name="email" placeholder="Voer je E-mailadres in" required>
            <small class="error-msg"></small>
          </label>

          <label class="field">
            <span>Voor- en achternaam</span>
            <input type="text" name="full_name" placeholder="Voer je volledige naam in" required minlength="2">
            <small class="error-msg"></small>
          </label>

          <label class="field">
            <span>Wachtwoord</span>
            <input type="password" name="password" placeholder="Voer je wachtwoord in" required minlength="8">
            <small class="hint">Minimaal 8 tekens, met hoofdletter & cijfer aangeraden.</small>
            <small class="error-msg"></small>
          </label>

          <button class="primary" type="submit">Maak een account aan</button>
        </form>

        <p class="signin">Al een account? <a href="#" onclick="alert('Demo: loginpagina niet geïmplementeerd');return false;">Log in</a></p>

        <div class="socials" aria-label="Social links">
          <a href="#" aria-label="Instagram">
            <svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm5 5a5 5 0 1 0 5 5 5 5 0 0 0-5-5Zm6.5-.25a1.25 1.25 0 1 0 1.25 1.25A1.25 1.25 0 0 0 18.5 6.75Z"/></svg>
          </a>
          <a href="#" aria-label="Facebook">
            <svg viewBox="0 0 24 24"><path d="M13 22V12h3l1-4h-4V6a1 1 0 0 1 1-1h3V1h-3a5 5 0 0 0-5 5v2H6v4h3v10Z"/></svg>
          </a>
          <a href="#" aria-label="LinkedIn">
            <svg viewBox="0 0 24 24"><path d="M4.98 3.5A2.5 2.5 0 1 0 5 8.5a2.5 2.5 0 0 0-.02-5ZM3 9h4v12H3zm7 0h4v1.7h.06A4.4 4.4 0 0 1 18 9.2c2.9 0 5 1.9 5 6.1V21h-4v-5.1c0-1.7-.6-2.8-2-2.8-1.1 0-1.7.7-2 1.4a2.6 2.6 0 0 0-.1.9V21h-4z"/></svg>
          </a>
        </div>
      </div>
    </main>
  </div>

  <script src="script.js"></script>
</body>
</html>
