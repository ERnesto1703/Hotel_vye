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
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    if ($conn === 'sqlite' || empty($conn)) {
        $dbPath = $db ?: "/var/www/html/database/database.sqlite";
        $dsn = "sqlite:$dbPath";
        $pdo = new PDO($dsn, null, null, $options);
    } else {
        $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, $options);
    }
    
    echo "<h2 style='color:green'>Success! Connection established.</h2>";
    
    // Check if tables exist
    if ($conn === 'sqlite' || empty($conn)) {
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    } else {
        $stmt = $pdo->query("SHOW TABLES");
    }
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

    // Write permissions test
    echo "<h3>Testing Write Permissions:</h3>";
    try {
        if ($conn === 'sqlite' || empty($conn)) {
            $pdo->exec("CREATE TABLE IF NOT EXISTS test_write (id INTEGER PRIMARY KEY AUTOINCREMENT, val TEXT)");
            $pdo->exec("INSERT INTO test_write (val) VALUES ('test')");
            $pdo->exec("DROP TABLE test_write");
        } else {
            $pdo->exec("CREATE TABLE IF NOT EXISTS test_write (id INT AUTO_INCREMENT PRIMARY KEY, val VARCHAR(50))");
            $pdo->exec("INSERT INTO test_write (val) VALUES ('test')");
            $pdo->exec("DROP TABLE test_write");
        }
        echo "<p style='color:green'>✔ Write permissions are OK!</p>";
    } catch (\PDOException $e) {
        echo "<p style='color:red'>✘ Write failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

} catch (\PDOException $e) {
    echo "<h2 style='color:red'>Connection Failed!</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
