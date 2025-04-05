<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Inicialización de variables
$fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';

// Preparar la consulta SQL de forma segura con `prepared statements`
$sql = "SELECT * FROM ventas";
$params = [];
if ($fecha_inicio && $fecha_fin) {
    $sql .= " WHERE DATE(fecha) >= ? AND DATE(fecha) <= ?";
    $params = [$fecha_inicio, $fecha_fin];
}

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param("ss", $params[0], $params[1]); // 'ss' indica que ambos parámetros son cadenas
}
$stmt->execute();
$resultado = $stmt->get_result();

// Verificar si hay resultados
$ventas = [];
if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        $ventas[] = $fila;
    }
}

// Calcular el total de ventas
$total_ventas = 0;
foreach ($ventas as $venta) {
    $total_ventas += $venta['cantidad'] * $venta['precio'];
}

// Cerrar la conexión a la base de datos
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="reporte-container">
        <h1>Reporte de Ventas</h1>

        <?php if ($fecha_inicio && $fecha_fin): ?>
            <h3>Fechas seleccionadas: <?php echo htmlspecialchars($fecha_inicio); ?> a <?php echo htmlspecialchars($fecha_fin); ?></h3>
        <?php else: ?>
            <h3>No se ha seleccionado un rango de fechas.</h3>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Categoría</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($venta['cliente']); ?></td>
                        <td><?php echo htmlspecialchars($venta['categoria']); ?></td>
                        <td><?php echo htmlspecialchars($venta['producto']); ?></td>
                        <td><?php echo htmlspecialchars($venta['cantidad']); ?></td>
                        <td><?php echo number_format($venta['precio'], 2, ',', '.'); ?> €</td>
                        <td><?php echo number_format($venta['cantidad'] * $venta['precio'], 2, ',', '.'); ?> €</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">Total de Ventas</td>
                    <td><?php echo number_format($total_ventas, 2, ',', '.'); ?> €</td>
                </tr>
            </tfoot>
        </table>
                <!-- Botón de Imprimir -->
                <button onclick="imprimirReporte()">Imprimir Reporte</button>
    </div>
</body>
</html>
