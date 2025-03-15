<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturación</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .main-container {
            border: 2px solid black; /* Borde negro alrededor del contenedor */
            margin: 20px auto;
            width: 80%;
            height: 80px; /* Ajusta la altura del contenedor */
            overflow-y: unset; /* Habilita el scroll vertical */
            background-color: #f0f0f0; /* Fondo gris claro */
            padding: 10px;
        }
        /* Estilos para el modal */
        .modal {
            display: block; /* Mostrar el modal por defecto */
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Fondo oscuro semi-transparente */
        }

        .modal-content {
            position: absolute;
            top: 100px; /* Ajusta según la posición deseada */
            left: 50%;
            transform: translateX(-50%);
            width: 400px; /* Ancho del formulario */
            background-color: rgb(195, 195, 195); /* Fondo gris */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: relative; /* Necesario para posicionar el botón de cierre */
        }

        .modal-header {
            display: flex;
            justify-content: flex-end;
        }

        .close {
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        .modal-content label {
            display: block;
            margin-bottom: 10px;
        }

        .modal-content input,
        .modal-content select {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
        }

        .modal-content .buttons {
            display: flex;
            justify-content: space-between;
        }

        .modal-content .buttons button {
            padding: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="menu">
            <div class="logo-container">
                <img src="img/logo.png" alt="Logo" class="logo">
            </div>
            <div>
                <nav>
                <div>
                    <a href="usuarios.php" class="link" id="registro-link" style="background-color: rgb(192, 192, 192);">
                    <img src="img/registro.png" alt="Registro" class="icon">
                    <span class="title">Usuarios</span>
                </a></div>
                <a href="inventario.php" class="link" style="background-color: rgb(192, 192, 192);">
                    <img src="img/inventario.png" alt="Inventario" class="icon">
                    <span class="title">Inventario</span>
                </a>
                <a href="dashboard_admin.php" class="link" style="background-color: white;">
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
            <a href="generarfactura.php" onclick="openRegisterModal()">
                Generar factura
                <img src="img/generarfactura.png" width="30" alt="generarfactura">
            </a>
        </div>    
    <script src="script.js"></script>
</body>
</html>
