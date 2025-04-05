<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Realizar la consulta a la base de datos para obtener las ventas
$sql = "SELECT * FROM ventas"; // Asegúrate de que los campos 'cliente' y 'categoria' estén en la base de datos
$resultado = $conn->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Guardar las filas en un arreglo
    $ventas = [];
    while ($fila = $resultado->fetch_assoc()) {
        $ventas[] = $fila;
    }
} else {
    $ventas = [];
}

// Calcular el total de ventas
$total_ventas = 0;
foreach ($ventas as $venta) {
    $total_ventas += $venta['cantidad'] * $venta['precio'];
}

// Cerrar la conexión a la base de datos
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
    </div>
</body>
</html>
