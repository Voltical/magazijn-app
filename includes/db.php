<?php
/**
 * Database connectie bestand
 * ---------------------------
 * Dit bestand maakt een veilige PDO-verbinding met de MySQL-database.
 * Importeer dit in al je scripts met:
 *   require_once __DIR__ . '/includes/db.php';
 */

$host = 'localhost';           // Meestal 'localhost' bij XAMPP
$dbname = 'vista_portal';      // Database naam
$username = 'root';            // Standaard gebruiker in XAMPP
$password = '';                // Leeg wachtwoord bij XAMPP (tenzij je er één hebt ingesteld)

try {
    // PDO-verbinding maken
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // gooit exceptions bij fouten
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // standaard fetch mode
            PDO::ATTR_EMULATE_PREPARES => false             // native prepared statements
        ]
    );
} catch (PDOException $e) {
    // Als er iets fout gaat, toon een nette foutmelding
    die("❌ Database connectie mislukt: " . $e->getMessage());
}
?>
