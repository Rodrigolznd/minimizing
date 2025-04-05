<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}

// Obtener los parámetros desde la URL
$fechainicio = isset($_GET['fechainicio']) ? $_GET['fechainicio'] : '';
$fechafin = isset($_GET['fechafin']) ? $_GET['fechafin'] : '';

// Validar las fechas de entrada
if (!$fechainicio || !$fechafin) {
    echo "Fechas no válidas.";
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'miapp');
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Query para obtener las ventas dentro del rango de fechas
$query = "SELECT p.nombre, f.cliente, f.fecha, f.cantidad, f.precio 
          FROM facturas f
          JOIN productos p ON FIND_IN_SET(p.id, f.productos) > 0
          WHERE f.fecha BETWEEN ? AND ?";

// Preparar la consulta
$stmt = $conexion->prepare($query);
$stmt->bind_param("ss", $fechainicio, $fechafin); // "ss" indica que son cadenas (strings)

// Ejecutar la consulta
$stmt->execute();
$result = $stmt->get_result();

$ventas = [];
$totalGeneral = 0; // Inicia el total general

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Añadir cada venta al array de ventas
        $ventas[] = $row;

        // Calcular el total general acumulando el total de cada venta
        $totalGeneral += $row['cantidad'] * $row['precio'];
    }
} else {
    $ventas = null;
}

// Cerrar la conexión
$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Generado de Ventas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="menu">
            <h1>Reporte Generado</h1>
            <a href="backend/logout.php">Cerrar sesión</a>
        </div>
    </header>

    <div class="main-container">
        <h2>Reporte de Ventas: <?php echo date("d-m-Y", strtotime($fechainicio)); ?> - <?php echo date("d-m-Y", strtotime($fechafin)); ?></h2>

        <?php if ($ventas): ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Fecha de Venta</th>
                        <th>Cantidad</th>
                        <th>Total Venta (COP)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                            <td><?php echo date("d-m-Y", strtotime($row['fecha'])); ?></td>
                            <td><?php echo $row['cantidad']; ?></td>
                            <td><?php echo number_format($row['cantidad'] * $row['precio'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-general">
                Total General (COP): <?php echo number_format($totalGeneral, 2, ',', '.'); ?>
            </div>
            <button class="print-button" onclick="window.print()">Imprimir Reporte</button>

        <?php else: ?>
            <p>No hay ventas en este rango de fechas.</p>
        <?php endif; ?>
    </div>

</body>
</html>
