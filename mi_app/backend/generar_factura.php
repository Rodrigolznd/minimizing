<?php
// Incluir la conexión a la base de datos
include 'conexion.php';

// Asegurarse de que el formulario se haya enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validar que los datos recibidos no estén vacíos
    if (empty($_POST['cliente']) || empty($_POST['fecha']) || empty($_POST['productos']) || empty($_POST['cantidad']) || empty($_POST['precio'])) {
        echo json_encode(['message' => 'Todos los campos son obligatorios.']);
        exit;
    }

    // Obtener los datos del formulario
    $cliente = mysqli_real_escape_string($conexion, $_POST['cliente']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $productos = mysqli_real_escape_string($conexion, $_POST['productos']);
    $cantidad = (int)$_POST['cantidad'];  // Asegurarse de que la cantidad es un número entero
    $precio = (float)$_POST['precio'];    // Asegurarse de que el precio es un número flotante

    // Validar cantidad y precio
    if ($cantidad <= 0) {
        echo json_encode(['message' => 'La cantidad debe ser mayor que 0.']);
        exit;
    }

    if ($precio <= 0) {
        echo json_encode(['message' => 'El precio debe ser mayor que 0.']);
        exit;
    }

    // Fecha de creación
    $fecha_creacion = date("Y-m-d H:i:s");

    // Insertar los datos en la base de datos
    $stmt = $conexion->prepare("INSERT INTO facturas (cliente, fecha, productos, cantidad, precio, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssids", $cliente, $fecha, $productos, $cantidad, $precio, $fecha_creacion);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Obtener el ID de la factura generada
        $id_factura = $stmt->insert_id;
        // Devolver el mensaje y el ID de la factura como JSON
        echo json_encode(['message' => 'Factura generada correctamente.', 'id' => $id_factura]);
    } else {
        // Error en la ejecución
        echo json_encode(['message' => 'Error al generar la factura: ' . $stmt->error]);
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();
}
?>
