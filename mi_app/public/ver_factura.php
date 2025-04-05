<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}
// Habilitar la visualización de errores para detectar problemas
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir la conexión a la base de datos
include '../backend/conexion.php';  // Ajusta la ruta según la estructura de tu proyecto

// Recuperar el ID de la factura (lo pasamos en la URL)
$id_factura = isset($_GET['id']) ? $_GET['id'] : 0;

// Verificar si el ID de la factura es válido
if ($id_factura <= 0) {
    echo "<p>ID de factura no válido. Asegúrese de que la URL contiene un ID de factura válido.</p>";
    exit;
}

// Obtener la información de la factura de la base de datos
$query = "SELECT * FROM facturas WHERE id = ?";
$stmt = $conexion->prepare($query);

// Verificamos si la preparación de la consulta fue exitosa
if ($stmt === false) {
    echo "Error en la preparación de la consulta: " . $conexion->error;
    exit;
}

$stmt->bind_param("i", $id_factura);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se obtuvo el resultado
if ($result->num_rows > 0) {
    $factura = $result->fetch_assoc();
    ?>
    
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Factura No. <?php echo $factura['id']; ?></title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                padding: 10px;
                background-color: #f4f4f9;
            }
            .factura-container {
                width: 80%;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #ffffff;
            }
            .factura-container h1 {
                text-align: center;
                color: #333;
            }
            .factura-container p {
                font-size: 1.2em;
                margin: 10px 0;
            }
            .factura-container strong {
                color: #555;
            }
            .total {
                font-size: 1.5em;
                font-weight: bold;
                color: #28a745;
                margin-top: 20px;
            }
            .button-container {
                text-align: center;
                margin-top: 30px;
            }
            .print-button {
                padding: 10px 20px;
                background-color: #28a745;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 1em;
            }
            .print-button:hover {
                background-color: #218838;
            }
        </style>
    </head>
    <body>

    <div class="factura-container">
        <h1>Factura No. <?php echo $factura['id']; ?></h1>
        <p><strong>Cliente:</strong> <?php echo htmlspecialchars($factura['cliente']); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($factura['fecha']); ?></p>
        <p><strong>Productos:</strong> <?php echo htmlspecialchars($factura['productos']); ?></p>
        <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($factura['cantidad']); ?></p>
        <p><strong>Precio:</strong> <?php echo htmlspecialchars($factura['precio']); ?> $</p>
        
        <?php
        $total = $factura['cantidad'] * $factura['precio'];
        ?>
        <p class="total"><strong>Total:</strong> <?php echo number_format($total, 2); ?> $</p>
    </div>

    <div class="button-container">
        <button class="print-button" onclick="window.print()">Imprimir Factura</button>
    </div>

    </body>
    </html>

    <?php
} else {
    echo "<p>Factura no encontrada. Por favor, verifique el ID.</p>";
}

$stmt->close();
$conexion->close();
?>