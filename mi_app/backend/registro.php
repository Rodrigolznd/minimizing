<?php
include "conexion.php";

header("Content-Type: application/json");

$nombre = trim($_POST['nombre']);
$nombre_usuario = trim($_POST['nombre_usuario']);
$correo = trim($_POST['correo']);
$clave = trim($_POST['clave']);
$rol = trim($_POST['rol']);
$estado = isset($_POST['estado']) ? (int) $_POST['estado'] : 1; // Por defecto activo

// Validaciones de datos
if (empty($nombre) || empty($nombre_usuario) || empty($correo) || empty($clave) || empty($rol)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit;
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Formato de correo no válido."]);
    exit;
}

if (strlen($nombre_usuario) > 30 || strlen($correo) > 100 || strlen($nombre) > 100) {
    echo json_encode(["status" => "error", "message" => "Los campos exceden la longitud permitida."]);
    exit;
}

// Verificar si el correo ya está registrado
$sql_check = "SELECT id FROM usuarios WHERE correo = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("s", $correo);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo json_encode(["status" => "error", "message" => "El correo ya está registrado."]);
    exit;
}
$stmt_check->close();

// Hash de la contraseña
$clave_hash = password_hash($clave, PASSWORD_DEFAULT);

// Inserción segura con consulta preparada
$sql = "INSERT INTO usuarios (nombre, nombre_usuario, correo, clave, rol, estado) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssssi", $nombre, $nombre_usuario, $correo, $clave_hash, $rol, $estado);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registro exitoso"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error en el registro: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conexion->error]);
}

$conexion->close();
?>
