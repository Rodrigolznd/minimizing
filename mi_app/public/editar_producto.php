<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}

include 'conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener datos actuales del producto
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->execute([$id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo "Producto no encontrado.";
        exit();
    }
} else {
    echo "ID no especificado.";
    exit();
}

// Actualizar producto si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];

    $stmt = $pdo->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, categoria = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $precio, $categoria, $id]);

    header("Location: inventario.php");
    exit();
}
?>

<!-- Formulario para editar -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h2>Editar Producto</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br>

        <label>Descripción:</label>
        <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea><br>

        <label>Precio:</label>
        <input type="number" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required><br>

        <label>Categoría:</label>
        <select name="categoria" required>
            <option value="Muebles" <?php if($producto['categoria'] === 'Muebles') echo 'selected'; ?>>Muebles</option>
            <option value="Electronica" <?php if($producto['categoria'] === 'Electronica') echo 'selected'; ?>>Electrónica</option>
            <option value="Oficinas" <?php if($producto['categoria'] === 'Oficinas') echo 'selected'; ?>>Oficinas</option>
        </select><br>

        <button type="submit">Guardar cambios</button>
        <a href="inventario.php">Cancelar</a>
    </form>
</body>
</html>
