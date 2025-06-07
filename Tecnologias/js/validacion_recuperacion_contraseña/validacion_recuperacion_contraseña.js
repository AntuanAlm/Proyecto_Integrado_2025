document.addEventListener("DOMContentLoaded", function () { // Espera a que el DOM esté cargado
    const formularioCambio = document.getElementById("formulario-cambio"); // Obtiene el formulario
    const inputNuevaContrasena = document.getElementById("nueva_contrasena"); // Campo de nueva contraseña
    const inputConfirmarContrasena = document.getElementById("confirmar_contrasena"); // Campo de confirmación
    const mensajeErrorContrasena = document.getElementById("error-contrasena"); // Mensaje de error de contraseña
    const mensajeErrorConfirmar = document.getElementById("error-confirmar"); // Mensaje de error de confirmación

    formularioCambio.addEventListener("submit", function (event) { // Evento al enviar el formulario
        event.preventDefault(); // Previene el envío por defecto

        const nuevaContrasena = inputNuevaContrasena.value.trim(); // Obtiene y limpia la nueva contraseña
        const confirmarContrasena = inputConfirmarContrasena.value.trim(); // Obtiene y limpia la confirmación

        let errores = false; // Variable para controlar si hay errores

        if (nuevaContrasena.length < 8) { // Verifica longitud mínima
            mensajeErrorContrasena.textContent = "⚠️ La contraseña debe tener al menos 8 caracteres.";
            errores = true;
        } else if (!/[A-Z]/.test(nuevaContrasena)) { // Verifica mayúscula
            mensajeErrorContrasena.textContent = "⚠️ Debe incluir al menos una letra mayúscula.";
            errores = true;
        } else if (!/\d/.test(nuevaContrasena)) { // Verifica número
            mensajeErrorContrasena.textContent = "⚠️ Debe incluir al menos un número.";
            errores = true;
        } else if (!/[!@#$%^&*]/.test(nuevaContrasena)) { // Verifica carácter especial
            mensajeErrorContrasena.textContent = "⚠️ Debe incluir al menos un carácter especial.";
            errores = true;
        } else {
            mensajeErrorContrasena.textContent = ""; // Limpia mensaje de error de contraseña
        }

        if (nuevaContrasena !== confirmarContrasena) { // Verifica coincidencia de contraseñas
            mensajeErrorConfirmar.textContent = "⚠️ Las contraseñas no coinciden.";
            errores = true;
        } else {
            mensajeErrorConfirmar.textContent = ""; // Limpia mensaje de error de confirmación
        }

        if (errores) return; // Si hay errores, no envía el formulario

        formularioCambio.submit(); // Envía el formulario si no hay errores
    });
});
