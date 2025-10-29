<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "jouw_database";
$user = "jouw_gebruiker";
$pass = "jouw_wachtwoord";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT naam, hoeveelheid FROM producten");
    $labels = [];
    $values = [];

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $labels[] = $row['naam'];
        $values[] = (int)$row['hoeveelheid'];
    }

    echo json_encode(['labels' => $labels, 'values' => $values]);

} catch (PDOException $e){
    echo json_encode(['error' => $e->getMessage()]);
}
