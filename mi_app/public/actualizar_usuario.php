<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>
<?php
include 'conexion.php';

// Verificar si se recibe un ID
$id = $_GET['id'] ?? null;
$usuario = null;

if ($id) {
    // Consultar los datos del usuario
    $query = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: usuarios.php");
        exit;
    }
}

// Procesar la actualización del usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $nombre = $_POST['nombre'];
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $estado = $_POST['estado'];

    $updateQuery = "UPDATE usuarios SET nombre = :nombre, nombre_usuario = :nombre_usuario, correo = :correo, rol = :rol, estado = :estado WHERE id = :id";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute([
        'nombre' => $nombre,
        'nombre_usuario' => $nombre_usuario,
        'correo' => $correo,
        'rol' => $rol,
        'estado' => $estado,
        'id' => $id
    ]);

    header("Location: usuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Editar Usuario</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>

        <label for="nombre_usuario">Nombre de Usuario:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" required><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="usuario" <?php if ($usuario['rol'] === 'usuario') echo 'selected'; ?>>Usuario</option>
            <option value="admin" <?php if ($usuario['rol'] === 'admin') echo 'selected'; ?>>Admin</option>
            <option value="cliente" <?php if ($usuario['rol'] === 'cliente') echo 'selected'; ?>>Cliente</option>
        </select><br>

        <label for="estado">Estado:</label>
        <select id="estado" name="estado" required>
            <option value="1" <?php if ($usuario['estado'] == 1) echo 'selected'; ?>>Activo</option>
            <option value="0" <?php if ($usuario['estado'] == 0) echo 'selected'; ?>>Inactivo</option>
        </select><br>

        <button type="submit">Actualizar</button>
        <a href="editar_usuario.php">Cancelar</a>
    </form>
</body>
</html>
