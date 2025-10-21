<?php
session_start();
require_once '../includes/db.php';

// Controleer of het formulier correct is verzonden
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  $_SESSION['errors'] = ['Ongeldige aanvraagmethode.'];
  header('Location: ../index.php');
  exit;
}

// Controleer CSRF-token
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf']) {
  $_SESSION['errors'] = ['Ongeldige of verlopen sessie. Probeer het opnieuw.'];
  header('Location: ../index.php');
  exit;
}

// Gegevens ophalen
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$errors = [];

// ===== VALIDATIE =====
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Voer een geldig e-mailadres in.';
}
if (empty($password)) {
  $errors[] = 'Voer je wachtwoord in.';
}

// Stop als er fouten zijn
if (!empty($errors)) {
  $_SESSION['errors'] = $errors;
  header('Location: ../public/index.php');
  exit;
}

// ===== GEBRUIKER OPHALEN =====
$stmt = $pdo->prepare("SELECT id, fullname, email, password_hash, verified FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  $_SESSION['errors'] = ['Er bestaat geen account met dit e-mailadres.'];
  header('Location: ../public/index.php');
  exit;
}

// ===== WACHTWOORD CONTROLEREN =====
if (!password_verify($password, $user['password_hash'])) {
  $_SESSION['errors'] = ['Onjuist wachtwoord. Probeer het opnieuw.'];
  header('Location: ../public/index.php');
  exit;
}

// ===== (Optioneel) Controleer of account geverifieerd is =====
if (isset($user['verified']) && (int)$user['verified'] === 0) {
  $_SESSION['errors'] = ['Je account is nog niet geverifieerd.'];
  header('Location: ../public/index.php');
  exit;
}

// ===== LOGIN SUCCESVOL =====
$_SESSION['user'] = [
  'id' => $user['id'],
  'fullname' => $user['fullname'],
  'email' => $user['email']
];

$_SESSION['success'] = 'Welkom terug, ' . htmlspecialchars($user['fullname']) . '!';
header('Location: ../pages/dashboard.php');
exit;
