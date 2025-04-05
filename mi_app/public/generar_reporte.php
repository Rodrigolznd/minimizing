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
    <title>Generar reporte de ventas</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        /* Estilos para el contenedor principal */
        .main-container {
            border: 2px solid black; /* Borde negro alrededor del contenedor */
            margin: 20px auto;
            width: 80%;
            height: 80px; /* Ajusta la altura del contenedor */
            overflow-y: auto; /* Habilita el scroll vertical */
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
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            width: 400px;
            background-color: rgb(195, 195, 195);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: relative;
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

        .modal-content input {
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
                    <a href="usuarios.php" class="link" id="registro-link" style="background-color: rgb(192, 192, 192);">
                        <img src="img/registro.png" alt="Registro" class="icon">
                        <span class="title">Usuarios</span>
                    </a>
                    <a href="inventario.php" class="link" style="background-color: white">
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

    <!-- Contenedor principal con scroll -->
    <div class="main-container">
        <!-- Sección de acciones (Registrar, Editar, Eliminar) -->
        <div id="registro-acciones" class="acciones">
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="productos_registrados.php">
                Productos Registrados
                <img src="img/productoregistrado.png" width="30" alt="registrarproducto">
            </a>
            <?php endif; ?>
            <div class="separator"></div>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="registrar_producto.php" onclick="openRegisterModal()">
                Registrar Producto
                <img src="img/registrarproducto.png" width="30" alt="registrarproducto">
            </a>
            <?php endif; ?>
            <div class="separator"></div>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="javascript:void(0);" onclick="openRegisterModal()">
                Generar reporte
                <img src="img/generarreporte.png" width="30" alt="generarreporte">
            </a>
            <?php endif; ?>
        </div>       

        <!-- Modal para generar reporte -->
        <div id="registerModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" onclick="closeRegisterModal()">&times;</span>
                </div>
                <h2>Generar reporte de ventas</h2>
                <form method="GET" action="reporte.php">

            <label for="fecha_inicio">Fecha de Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin" required>

    <br><br>

    <div class="buttons">
        <button type="submit">Generar reporte</button>
        <button type="button" onclick="closeRegisterModal()">Cancelar</button>
    </div>
</form>

            </div>
        </div>
    </div>


    <script>
        function openRegisterModal() {
            document.getElementById('registerModal').style.display = 'block';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('registerModal')) {
                closeRegisterModal();
            }
        };
    </script>
</body>
</html>
