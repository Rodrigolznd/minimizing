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
            display: none;
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
        <?php if ($_SESSION['rol'] === 'admin'): ?>
        <!-- Botón que abrirá el modal -->
        <a href="#" id="openModalBtn">
            Generar Factura
            <img id="openModalImg" src="img/generarfactura.png" width="30" alt="Generar Factura">
        </a>     
        <?php endif; ?>
    </div>

<!-- Modal para Generar Factura -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close" id="closeModalBtn">&times;</span>
        </div>
        <h2>Generar Factura</h2>
        <form id="generarFacturaForm" enctype="multipart/form-data">
            <label for="cliente">Cliente:</label>
            <input type="text" id="cliente" name="cliente" placeholder="Nombre del cliente" required>

            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="productos">Productos:</label>
            <textarea id="productos" name="productos" placeholder="Descripción de los productos" rows="4" required></textarea>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" placeholder="Cantidad de productos" required>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" placeholder="Precio del producto" required>

            <div class="buttons">
                <button type="submit">Generar Factura</button>
                <button type="button" id="cancelModalBtn">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="js/generar_factura.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const registerModal = document.getElementById("registerModal");
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const cancelModalBtn = document.getElementById("cancelModalBtn");
        const registerIcon = document.querySelector("#openModalBtn img");

        openModalBtn.addEventListener("click", function(event) {
            event.preventDefault();
            registerModal.style.display = "block";
            registerIcon.src = "img/clicgenerarfactura.png";
        });

        function closeRegisterModal() {
            registerModal.style.display = "none";
            registerIcon.src = "img/generarfactura.png";
        }

        closeModalBtn.addEventListener("click", closeRegisterModal);
        cancelModalBtn.addEventListener("click", closeRegisterModal);

        window.onclick = function(event) {
            if (event.target === registerModal) {
                closeRegisterModal();
            }
        }
    });
</script>
</body>
</html>
