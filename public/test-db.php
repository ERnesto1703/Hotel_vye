<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Checking Database Connection</h1>";

$host = getenv('DB_HOST');
$db   = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');
$conn = getenv('DB_CONNECTION');
$app_key = getenv('APP_KEY');
$app_debug = getenv('APP_DEBUG');

echo "<p>APP_KEY: " . ($app_key ? "Set (length: " . strlen($app_key) . ")" : "<span style='color:red'>NOT SET</span>") . "</p>";
echo "<p>APP_DEBUG: " . ($app_debug !== false ? htmlspecialchars($app_debug) : "<span style='color:orange'>NOT SET</span>") . "</p>";
echo "<p>Connection: $conn</p>";
echo "<p>Host: $host</p>";
echo "<p>Database: $db</p>";
echo "<p>Username: $user</p>";
echo "<p>Password: " . ($pass ? "Set (length: " . strlen($pass) . ")" : "Not Set/Empty") . "</p>";

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<h2 style='color:green'>Success! Connection established.</h2>";
    
    // Check if tables exist
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<h3>Tables in Database:</h3>";
    if (empty($tables)) {
        echo "<p style='color:orange'>No tables found. Migrations have not run.</p>";
    } else {
        echo "<ul>";
        foreach ($tables as $table) {
            echo "<li>" . htmlspecialchars($table) . "</li>";
        }
        echo "</ul>";
    }
} catch (\PDOException $e) {
    echo "<h2 style='color:red'>Connection Failed!</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
