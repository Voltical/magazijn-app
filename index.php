<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Maak een account — Vista-stijl</title>
  <style>
    :root {
      --bg: #0f1216;
      --card: #ffffff;
      --text: #0e0e0e;
      --muted: #6b7280;
      --brand: #0ea5e9; /* cyaan/blauw accent */
      --brand-dark: #0284c7;
      --shadow: 0 10px 25px rgba(0,0,0,.15);
      --radius: 16px;
    }
    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      margin: 0;
      font: 16px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, "Helvetica Neue", Arial, "Apple Color Emoji", "Segoe UI Emoji";
      color: var(--text);
      background: #f3f4f6;
    }

    .grid {
      display: grid;
      grid-template-columns: 1.1fr 1fr;
      min-height: 100dvh;
    }

    /* LEFT: photo banner */
    .banner {
      position: relative;
      overflow: hidden;
      background: #000;
    }
    .banner::before {
      content: "";
      position: absolute; inset: 0;
      background: url('https://images.unsplash.com/photo-1553877522-43269d4ea984?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
      filter: saturate(1.05);
      transform: scale(1.02);
    }
    .banner::after {
      content: "";
      position: absolute; inset: 0;
      background: linear-gradient(90deg, rgba(0,0,0,.55), rgba(0,0,0,.25) 35%, rgba(0,0,0,.25) 65%, rgba(0,0,0,.6));
    }
    .banner-inner {
      position: absolute; inset: 0;
      display: grid; align-content: space-between;
      padding: clamp(20px, 3vw, 32px);
      color: #fff;
    }
    .logo {
      display: inline-flex; gap: 10px; align-items: baseline;
      font-weight: 800; letter-spacing: .06em; text-transform: uppercase;
      font-size: clamp(22px, 2.2vw, 30px);
    }
    .logo span { opacity: .85; font-weight: 700; font-size: .7em; letter-spacing: .1em; }

    .claim {
      margin-top: auto;
      padding: 18px 0 8px;
    }
    .claim h1 {
      margin: 0 0 6px;
      font-size: clamp(26px, 3.2vw, 40px);
      line-height: 1.1;
      font-weight: 800;
      text-shadow: 0 6px 26px rgba(0,0,0,.35);
    }
    .claim p {
      margin: 0;
      font-size: clamp(16px, 2vw, 22px);
      font-weight: 700;
      color: #ffead5;
      text-shadow: 0 6px 26px rgba(0,0,0,.35);
    }

    /* RIGHT: form card */
    .panel {
      display: grid; place-items: center;
      padding: clamp(24px, 5vw, 48px);
      background: #f9fafb;
    }
    .card {
      width: min(520px, 100%);
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      padding: clamp(22px, 4vw, 32px);
      border: 1px solid #eef1f5;
    }
    .card header { text-align: center; margin-bottom: 16px; }
    .avatar {
      width: 64px; height: 64px; display: grid; place-items: center;
      margin: 0 auto 10px; border-radius: 999px; border: 6px solid #f1f5f9;
      background: radial-gradient(circle at 30% 30%, #334155, #111827);
      color: #fff; font-weight: 700;
    }
    .title { font-size: 22px; font-weight: 800; margin: 0; }

    .oauth {
      display: grid; gap: 10px; margin: 16px 0 8px;
    }
    .btn {
      appearance: none; border: 0; background: #e6f4ff; color: #0b2e46;
      padding: 12px 14px; border-radius: 10px; font-weight: 700; cursor: pointer;
      display: inline-flex; align-items: center; justify-content: center; gap: 10px;
      transition: transform .05s ease, box-shadow .2s ease, background .2s ease;
      box-shadow: 0 2px 0 rgba(2,132,199,.2);
    }
    .btn:hover { transform: translateY(-1px); }
    .btn:active { transform: translateY(0); box-shadow: none; }
    .btn-alt { background: #f3f4f6; color: #111827; box-shadow: 0 2px 0 rgba(17,24,39,.12); }

    .divider { display: grid; grid-template-columns: 1fr auto 1fr; gap: 12px; align-items: center; margin: 10px 0 2px; color: var(--muted); font-size: 14px; }
    .divider::before, .divider::after { content: ""; height: 1px; background: #e5e7eb; }

    form { margin-top: 12px; display: grid; gap: 12px; }
    .field { display: grid; gap: 6px; }
    label { font-weight: 700; font-size: 13px; color: #374151; }
    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%; padding: 12px 14px; border-radius: 10px; border: 1px solid #e5e7eb;
      background: #f9fafb; outline: none; transition: border .15s ease, background .15s ease, box-shadow .2s ease;
    }
    input:focus { border-color: var(--brand); background: #fff; box-shadow: 0 0 0 4px rgba(14,165,233,.15); }

    .submit {
      margin-top: 6px;
      display: inline-flex; width: 100%; align-items: center; justify-content: center;
      background: var(--brand); color: #fff; font-weight: 800; padding: 12px 14px; border-radius: 10px; border: 0; cursor: pointer;
      box-shadow: 0 8px 16px rgba(14,165,233,.2);
    }
    .submit:hover { background: var(--brand-dark); }

    .meta { margin-top: 10px; text-align: center; font-size: 14px; color: var(--muted); }
    .meta a { color: var(--brand-dark); text-decoration: none; font-weight: 700; }

    .socials { margin-top: 12px; display: flex; gap: 10px; justify-content: center; font-size: 18px; color: #6b7280; }

    .flag {
      width: 18px; height: 12px; border-radius: 2px; overflow: hidden; box-shadow: inset 0 0 0 1px rgba(0,0,0,.1);
      display: inline-block; position: relative; transform: translateY(1px);
      background: linear-gradient(#0052b4 0 33.33%, #ffce00 33.33% 66.66%, #d80027 66.66%);
    }

    @media (max-width: 980px) { .grid { grid-template-columns: 1fr; } .banner { display:none; } }
  </style>
</head>
<body>
  <main class="grid">
    <!-- LEFT SIDE -->
    <aside class="banner" aria-hidden="true">
      <div class="banner-inner">
        <div class="logo" title="VISTA college">
          VISTA <span>college</span>
        </div>
        <div class="claim">
          <h1>Jouw magazijn.</h1>
          <p>Jouw controle</p>
        </div>
      </div>
    </aside>

    <!-- RIGHT SIDE -->
    <section class="panel">
      <div class="card" role="region" aria-labelledby="title">
        <header>
          <div class="avatar" aria-hidden="true">🔒</div>
          <h2 id="title" class="title">Maak een account</h2>
        </header>

        <div class="oauth">
          <button type="button" class="btn" title="Inloggen met Vista (voorbeeld)">
            <span class="flag" aria-hidden="true"></span>
            <span>Maak een account met Vista</span>
          </button>
        </div>

        <div class="divider">of</div>

        <!-- IMPORTANT: Update the action attribute to your PHP endpoint (bijv. register.php) -->
        <form method="post" action="register.php" autocomplete="on" novalidate>
          <!-- voorbeeld van (optionele) CSRF token -->
          <input type="hidden" name="csrf_token" value="{{CSRF_TOKEN}}" />

          <div class="field">
            <label for="email">E-mailadres</label>
            <input id="email" name="email" type="email" inputmode="email" required placeholder="Voer je e-mailadres in" />
          </div>

          <div class="field">
            <label for="username">Voor- en achternaam</label>
            <input id="username" name="username" type="text" autocomplete="name" required placeholder="Voer je achternaam in" />
          </div>

          <div class="field">
            <label for="fullname">Voor je volledige naam in</label>
            <input id="fullname" name="fullname" type="text" autocomplete="name" placeholder="Bijv. Jan Jansen" />
          </div>

          <div class="field">
            <label for="password">Wachtwoord</label>
            <input id="password" name="password" type="password" minlength="8" required placeholder="Voer je wachtwoord in" />
          </div>