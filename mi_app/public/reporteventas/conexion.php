<?php
$host = "localhost"; // O el servidor de tu base de datos
$usuario = "root"; // Tu usuario de MySQL
$contraseña = ""; // Tu contraseña de MySQL
$nombre_bd = "ventas_db"; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $usuario, $contraseña, $nombre_bd);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
