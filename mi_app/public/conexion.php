<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>
<?php
// Datos de conexión
$host = 'localhost';
$dbname = 'mi_app';
$username = 'root';
$password = '';

// Usando PDO para la conexión
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión PDO: " . $e->getMessage() . "<br>";
}

// Usando MySQLi para la conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Comprobar la conexión de MySQLi
if ($conn->connect_error) {
    die("Conexión fallida con MySQLi: " . $conn->connect_error);
} else {
}
?>
