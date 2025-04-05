<?php
// Incluir la conexión a la base de datos
include('conexion.php');

// Verificar si los datos fueron enviados por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    $cliente = $_POST['cliente'];
    $categoria = $_POST['categoria'];
    
    $sql = "INSERT INTO ventas (producto, cantidad, precio, fecha, cliente, categoria) 
            VALUES ('$producto', $cantidad, $precio, '$fecha', '$cliente', '$categoria')";    

    // Ejecutar la consulta y verificar si se insertó correctamente
    if ($conn->query($sql) === TRUE) {
        echo "Venta registrada exitosamente!";
    } else {
        echo "Error al registrar la venta: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
