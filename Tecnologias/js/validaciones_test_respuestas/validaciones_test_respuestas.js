// Espera a que el contenido del documento esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {
    // Añade un listener al formulario con id "formularioTest" para el evento submit
    document.getElementById("formularioTest").addEventListener("submit", function(event) {
        // Selecciona todas las respuestas marcadas (inputs tipo radio seleccionados)
        const respuestasMarcadas = document.querySelectorAll('input[type="radio"]:checked');

        // Si no hay ninguna respuesta marcada
        if (respuestasMarcadas.length === 0) {
            // Previene el envío del formulario
            event.preventDefault();

            // Muestra una alerta indicando que no se ha respondido ninguna pregunta
            alert("No has respondido ninguna pregunta.");
            // Pregunta al usuario si está seguro de enviar el test sin responder
            const confirmar = confirm("¿Estás seguro que quieres enviar el test?");
            if (confirmar) {
                // Si confirma, envía el formulario
                this.submit();
            } else {
                // Si cancela, no hace nada más
                return false;
            }
        }
    });
});
