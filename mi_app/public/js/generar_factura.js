document.getElementById("generarFacturaForm").addEventListener("submit", function(e) {
    e.preventDefault(); // Evita que el formulario se recargue

    // Capturar valores del formulario
    const cliente = document.getElementById("cliente").value.trim();
    const fecha = document.getElementById("fecha").value.trim();
    const productos = document.getElementById("productos").value.trim();
    const cantidad = document.getElementById("cantidad").value.trim();
    const precio = document.getElementById("precio").value.trim();

    // Validación básica (evita enviar datos vacíos)
    if (!cliente || !fecha || !productos || !cantidad || !precio) {
        alert("Todos los campos son obligatorios.");
        return;
    }

    // Validación de cantidad (debe ser un número positivo)
    if (isNaN(cantidad) || parseInt(cantidad) <= 0) {
        alert("La cantidad debe ser un número válido mayor a 0.");
        return;
    }

    // Validación de precio (debe ser un número positivo)
    if (isNaN(precio) || parseFloat(precio) <= 0) {
        alert("El precio debe ser un número válido mayor a 0.");
        return;
    }

    // Validación de fecha (verificar si es una fecha válida)
    const fechaRegex = /^\d{4}-\d{2}-\d{2}$/; // Formato de fecha YYYY-MM-DD
    if (!fechaRegex.test(fecha)) {
        alert("La fecha debe estar en formato YYYY-MM-DD.");
        return;
    }

    // Crear FormData para enviar los datos del formulario
    const formData = new FormData();
    formData.append("cliente", cliente);
    formData.append("fecha", fecha);
    formData.append("productos", productos);
    formData.append("cantidad", cantidad);
    formData.append("precio", precio);

    // Enviar los datos al backend con fetch
    fetch("../backend/generar_factura.php", {
        method: "POST",
        body: formData
    })
    .then(response => {
        // Comprobar si la respuesta es válida
        if (!response.ok) {
            throw new Error('Error en la solicitud: ' + response.statusText);
        }
        return response.json(); // Asegurarse de que la respuesta es JSON
    })
    .then(data => {
        if (data.id) {
            // Si la factura se genera correctamente, redirige a la página para verla
            alert(`Factura generada correctamente. ID: ${data.id}`);
            window.location.href = `ver_factura.php?id=${data.id}`;
        } else {
            // Si no existe un ID, mostrar el mensaje de error
            alert(data.message || "Hubo un problema al generar la factura.");
        }
    })
    .catch(error => {
        // Capturar cualquier error en la solicitud o procesamiento
        console.error(error);
        alert("Error en el registro: " + error.message);
    });
});
