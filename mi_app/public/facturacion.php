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
            width: 70%;
            height: 70px; /* Ajusta la altura del contenedor */
            overflow-y: unset; /* Habilita el scroll vertical */
            background-color: #f0f0f0; /* Fondo gris claro */
            padding: 10px;
        }
        /* Estilos para el modal */
        .modal {
            display: none; /* Mostrar el modal por defecto */
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
            <a href="#" onclick="openRegisterModal()">
                Generar factura
                <img src="img/generarfactura.png" width="30" alt="generarfactura">
            </a>
        </div>    
            <!-- Modal para generar factura -->
            <div id="registerModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close" onclick="closeRegisterModal()">&times;</span>
                    </div>
                    <h2>Generar factura</h2>
                    <form id="registerForm">
                        <label for="cliente">Cliente:</label>
                        <input type="text" id="cliente" name="cliente" >
                        <br><br>
                        
                        <label for="fecha">Fecha:</label>
                        <input type="date" id="fecha" name="fecha" >
                        <br><br>
                        
                        <label for="productos">Productos:</label>
                        <textarea id="productos" name="productos"></textarea>
                        <br><br>
                        
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad">
                        <br><br>
                        
                        <label for="precio">Precio Total (COP):</label>
                        <input type="text" id="precio" name="precio" >
                        <br><br>
                        
                        <div class="buttons">
                            <button type="submit">Generar factura</button>
                            <button type="button" onclick="closeRegisterModal()">Cancelar</button>
                        </div>
                    </form>
                </div>
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

        // Cerrar el modal si se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target == document.getElementById('registerModal')) {
                closeRegisterModal();
            }
        }
    </script>
</body>
</html>
