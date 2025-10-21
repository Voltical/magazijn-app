<?php
session_start();
if (empty($_SESSION['user'])) {
  header('Location: index.php');
  exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
</head>
<body>
  <h1>Welkom, <?= htmlspecialchars($user['fullname']) ?>!</h1>
  <p>Je bent succesvol ingelogd.</p>
  <a href="logout.php">Uitloggen</a>
</body>
</html>
