<?php
include 'conexion.php';

// Obtener todos los usuarios
$query = "SELECT id, nombre, nombre_usuario, correo, rol, estado, fecha_registro FROM usuarios";
$stmt = $pdo->query($query);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Usuarios Registrados</h1>
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                    <td><?php echo $usuario['estado'] ? 'Activo' : 'Inactivo'; ?></td>
                    <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
