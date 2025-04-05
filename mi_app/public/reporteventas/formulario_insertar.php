<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Venta</title>
    <link rel="stylesheet" href="styles.css"> <!-- Si tienes CSS personalizado -->
</head>
<body>
    <div class="form-container">
        <h1>Insertar Venta</h1>
        <form action="insertar_venta.php" method="POST">
            <label for="producto">Producto:</label>
            <input type="text" id="producto" name="producto" required>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" required>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>

            <label for="fecha">Fecha:</label>
            <input type="datetime-local" id="fecha" name="fecha" required>

            <input type="submit" value="Insertar Venta">
        </form>
    </div>
</body>
</html>
