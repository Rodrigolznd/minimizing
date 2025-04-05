<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>
<?php
include 'conexion.php';

// Eliminar producto si se ha enviado el ID por GET
if (isset($_GET['eliminar_id'])) {
    $idEliminar = $_GET['eliminar_id'];
    $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->execute([$idEliminar]);

    // Redirige para evitar reenvío del formulario al recargar
    header("Location: producto_eliminado.php");
    exit();
}

// Obtener todos los productos
$query = "SELECT id, nombre, descripcion, precio, categoria, fecha_registro FROM productos";
$stmt = $pdo->query($query);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="menu">
            <div class="logo-container">
                <img src="img/logo.png" alt="Logo" class="logo">
            </div>  
            <div>
                <nav>
                    <a href="usuarios.php" class="link" id="registro-link" style="background-color: rgb(192, 192, 192);">
                        <img src="img/registro.png" alt="Registro" class="icon">
                        <span class="title">Usuarios</span>
                    </a>
                    <a href="dashboard_admin.php" class="link" style="background-color: white">
                        <img src="img/inventario.png" alt="Inventario" class="icon">
                        <span class="title">Inventario</span>
                    </a>
                    <a href="facturacion.php" class="link" style="background-color: rgb(192, 192, 192);">
                        <img src="img/factura.png" alt="Facturación" class="icon">
                        <span class="title">Facturación</span>
                    </a>
                    <h1>Bienvenido Administrador, <?php echo $_SESSION['nombre']; ?> 🛠️</h1>
                    <a href="../backend/logout.php">Cerrar sesión</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="main-container">
        <div id="registro-acciones" class="acciones">
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="inventario.php">
                Productos Registrados
                <img src="img/clicproductoregistrado.png" width="30" alt="registrarproducto">
            </a>
            <?php endif; ?>
            <div class="separator"></div>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="registrar_producto.php">
                Registrar Producto
                <img src="img/registrarproducto.png" width="30" alt="registrarproducto">
            </a>
            <?php endif; ?>
            <div class="separator"></div>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="generar_reporte.php">
                Generar reporte
                <img src="img/generarreporte.png" width="30" alt="generarreporte">
            </a>
            <?php endif; ?>
         </div>       

         <!-- Tabla de productos -->
         <div class="container-fluid">
            <br>
            <table class="custom-table">
              <thead>
                <tr>
                <th>Nombre del producto</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Categoría</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($producto['precio']); ?></td>
                    <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                    <td>
                        <a href="editar_producto.php?id=<?php echo $producto['id']; ?>">Editar</a>
                        <a href="?eliminar_id=<?php echo $producto['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>  
    </div>
</body>
</html>
