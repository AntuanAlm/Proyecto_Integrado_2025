// Esperamos a que el DOM esté completamente cargado antes de ejecutar cualquier código
document.addEventListener("DOMContentLoaded", function () {

    // Obtenemos referencias al formulario y a los campos de entrada
    const formulario = document.getElementById("formulario-login");
    const inputCorreo = document.getElementById("correo");
    const inputContrasena = document.getElementById("contrasena");

    // Referencias a los elementos donde mostraremos los errores (ya separados)
    const mensajeErrorCorreo = document.getElementById("mensaje-error-correo");
    const mensajeErrorContrasena = document.getElementById("mensaje-error-contrasena");

    // Añadimos un manejador de evento para cuando el formulario se intente enviar
    formulario.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevenimos el envío por defecto del formulario

        // Obtenemos los valores introducidos por el usuario, quitando espacios
        const correo = inputCorreo.value.trim();
        const contrasena = inputContrasena.value.trim();

        // Enviamos los datos al servidor utilizando fetch (AJAX)
        fetch("../../php/verificar_login_profes/verificar_login_profes.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ correo, contrasena }) // Enviamos los datos como JSON
        })
        .then(response => response.text()) // Recibimos la respuesta como texto
        .then(texto => {
            try {
                const data = JSON.parse(texto); // Intentamos convertir el texto a objeto JSON

                // Limpiamos mensajes de error anteriores
                mensajeErrorCorreo.textContent = "";
                mensajeErrorContrasena.textContent = "";

                if (data.error) {
                    // Si hay un error, lo mostramos en el campo correspondiente
                    if (data.error.includes("Correo")) {
                        mensajeErrorCorreo.textContent = `⚠️ ${data.error}`;
                        mensajeErrorCorreo.style.color = "red";
                    } else if (data.error.includes("Contraseña")) {
                        mensajeErrorContrasena.textContent = `⚠️ ${data.error}`;
                        mensajeErrorContrasena.style.color = "red";
                    } else {
                        // Si el error no es específico, lo mostramos en ambos
                        mensajeErrorCorreo.textContent = `⚠️ ${data.error}`;
                        mensajeErrorCorreo.style.color = "red";
                        mensajeErrorContrasena.textContent = `⚠️ ${data.error}`;
                        mensajeErrorContrasena.style.color = "red";
                    }
                } else {
                    // Si no hay errores, se considera login válido y se envía el formulario
                    formulario.submit();
                }
            } catch (error) {
                // Si hay un error al procesar el JSON, mostramos un mensaje genérico
                console.error("Error al procesar JSON:", error);
                mensajeErrorCorreo.textContent = "";
                mensajeErrorContrasena.textContent = "⚠️ Error inesperado en el servidor.";
                mensajeErrorContrasena.style.color = "red";
            }
        })
        .catch(error => {
            // Si no se puede conectar con el servidor, mostramos un mensaje
            console.error("Error en la conexión:", error);
            mensajeErrorCorreo.textContent = "";
            mensajeErrorContrasena.textContent = "⚠️ No se pudo conectar con el servidor.";
            mensajeErrorContrasena.style.color = "red";
        });
    });
});
