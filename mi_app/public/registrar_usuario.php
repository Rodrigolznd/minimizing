<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit();
}
?>
<?php
include 'conexion.php';

// Obtener todos los usuarios
$query = "SELECT id, nombre, nombre_usuario, correo, rol, estado, fecha_registro FROM usuarios";
$stmt = $pdo->query($query);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de usuarios</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
               /* Estilos para el modal */
        .modal {
            display: block; /* Ocultar el modal por defecto */
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
                    <a href="dashboard_admin.php" class="link" style="background-color: rgb(255, 255, 255);">
                        <img src="img/registro.png" alt="Gestión" class="icon">
                        <span class="title">Usuarios</span>
                    </a>
                    <a href="inventario.php" class="link" style="background-color: rgb(192, 192, 192);">
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

    <div class="main-container">
        <div id="registro-acciones" class="acciones">
            <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="#" id="openModalBtn">
             Registrar Usuario<img id="registerIcon" src="img/clicregistrar.png" width="30" alt="Registrar">
        </a>
            <?php endif; ?>
            <div class="separator"></div>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
        <a href="editar_usuario.php">
             Editar <img src="img/editar.png" width="30" alt="Editar">
        </a>
        <?php endif; ?>
            <div class="separator"></div>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
            <a href="eliminar_usuario.php">
             Eliminar <img src="img/eliminar.png" width="30" alt="Eliminar"></a>
            <?php endif; ?>
        </div>

        <div class="container-fluid">
            <br>
            <table class="custom-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                    <td><?php echo $usuario['estado'] ? 'Activo' : 'Inactivo'; ?></td>
                    <td><?php echo htmlspecialchars($usuario['fecha_registro']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>  
    </div>

    <div id="registerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" id="closeModalBtn">&times;</span>
            </div>
            <h2>Registrar Usuario</h2>
    <form id="registroForm">
    <label for="nombre">Nombre completo:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required autocomplete="name">

    <label for="nombre_usuario">Nombre de usuario:</label>
    <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Ingrese el nombre de usuario" required autocomplete="username" minlength="4" maxlength="30">

    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" required autocomplete="email">

    <label for="clave">Contraseña:</label>
    <input type="password" id="clave" name="clave" placeholder="Ingrese la contraseña" required minlength="6" maxlength="20" autocomplete="new-password">

    <label for="rol">Rol:</label>
    <select id="rol" name="rol" required>
        <option value="" disabled selected>Seleccione un rol</option>
        <option value="usuario">Usuario</option>
        <option value="admin">Administrador</option>
        <option value="cliente">Cliente</option>
    </select>

    <div class="buttons">
        <button type="submit">Registrar</button>
        <button type="button" id="cancelModalBtn">Cancelar</button>
           </div>
        </form>

        </div>
    </div>



    <script src="js/registro.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const registerModal = document.getElementById("registerModal");
        const openModalBtn = document.getElementById("openModalBtn");
        const closeModalBtn = document.getElementById("closeModalBtn");
        const cancelModalBtn = document.getElementById("cancelModalBtn");
        const registerIcon = document.querySelector("#openModalBtn img"); // Selecciona la imagen dentro del enlace

        openModalBtn.addEventListener("click", function(event) {
            event.preventDefault();
            registerModal.style.display = "block";
            registerIcon.src = "img/clicregistrar.png"; // Cambia la imagen al abrir el modal
        });

        function closeRegisterModal() {
            registerModal.style.display = "none";
            registerIcon.src = "img/registrar.png"; // Cambia la imagen al cerrar el modal
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
