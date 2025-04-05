document.addEventListener("DOMContentLoaded", function() {
    const formulario = document.getElementById("generarForm");

    formulario.addEventListener("submit", function(event) {
        event.preventDefault();

        const fechainicio = document.getElementById("fechainicio").value;
        const fechafin = document.getElementById("fechafin").value;

        // Validación simple de las fechas
        if (!fechainicio || !fechafin) {
            alert("Por favor, ingrese ambas fechas.");
            return;
        }

        // Verificar que las fechas tienen el formato correcto (YYYY-MM-DD)
        const regexFecha = /^\d{4}-\d{2}-\d{2}$/;
        if (!regexFecha.test(fechainicio) || !regexFecha.test(fechafin)) {
            alert("Por favor, ingrese las fechas en formato correcto (YYYY-MM-DD).");
            return;
        }

        const fechaInicioObj = new Date(fechainicio);
        const fechaFinObj = new Date(fechafin);

        // Verificar que la fecha de inicio no sea mayor que la fecha de fin
        if (fechaInicioObj > fechaFinObj) {
            alert("La fecha de inicio no puede ser mayor que la fecha de fin.");
            return;
        }

        // Usamos el método GET para enviar las fechas al archivo PHP
        window.location.href = `backend/generar_reporte.php?fechainicio=${fechainicio}&fechafin=${fechafin}`;
    });
});
