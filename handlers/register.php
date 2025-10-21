<?php
session_start();
require_once '../config/db.php';

// Controleer of het formulier correct is verzonden
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['errors'] = ['Ongeldige aanvraagmethode.'];
  header('Location: ../index.php');
  exit;
}

// CSRF-check
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf']) {
  $_SESSION['errors'] = ['Ongeldige of verlopen sessie. Probeer het opnieuw.'];
  header('Location: ../index.php');
  exit;
}

// Gegevens ophalen
$email = trim($_POST['email'] ?? '');
$fullname = trim($_POST['fullname'] ?? '');
$password = $_POST['password'] ?? '';
$errors = [];

// ===== VALIDATIE =====
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Voer een geldig e-mailadres in.';
if (strlen($fullname) < 2) $errors[] = 'Voer je volledige naam in.';
if (strlen($password) < 8) $errors[] = 'Wachtwoord moet minstens 8 tekens bevatten.';

if (!empty($errors)) {
  $_SESSION['errors'] = $errors;
  header('Location: ../index.php');
  exit;
}

// ===== BESTAAT GEBRUIKER AL? =====
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
  $_SESSION['errors'] = ['Er bestaat al een account met dit e-mailadres.'];
  header('Location: ../index.php');
  exit;
}

// ===== ACCOUNT AANMAKEN =====
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$verifyToken = bin2hex(random_bytes(32));

try {
  $stmt = $pdo->prepare("
    INSERT INTO users (fullname, email, password_hash, verify_token)
    VALUES (?, ?, ?, ?)
  ");
  $stmt->execute([$fullname, $email, $hashedPassword, $verifyToken]);

  // ===== VERIFICATIE E-MAIL VERSTUREN =====
  $verifyLink = "https://jouwdomein.nl/handlers/verify.php?token=$verifyToken";

  $subject = "Verifieer je account bij Vista College";
  $message = "
    <h2>Welkom, $fullname!</h2>
    <p>Bedankt voor je registratie. Klik op onderstaande knop om je account te activeren:</p>
    <p><a href='$verifyLink' style='
      display:inline-block;
      background:#0ea5e9;
      color:#fff;
      padding:10px 18px;
      border-radius:6px;
      text-decoration:none;
    '>Account verifiëren</a></p>
    <p>Of kopieer deze link in je browser:<br>$verifyLink</p>
  ";

  $headers  = "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=UTF-8\r\n";
  $headers .= "From: Vista College <no-reply@jouwdomein.nl>\r\n";

  mail($email, $subject, $message, $headers);

  $_SESSION['success'] = 'Account aangemaakt! Controleer je e-mail om je account te verifiëren.';
  header('Location: ../public/index.php');
  exit;

} catch (PDOException $e) {
  $_SESSION['errors'] = ['Er is een fout opgetreden bij het registreren.'];
  header('Location: ../public/index.php');
  exit;
}
