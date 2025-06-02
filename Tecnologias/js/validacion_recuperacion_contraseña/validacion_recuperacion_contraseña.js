document.addEventListener("DOMContentLoaded", function () {
    const formularioCambio = document.getElementById("formulario-cambio");
    const inputNuevaContrasena = document.getElementById("nueva_contrasena");
    const inputConfirmarContrasena = document.getElementById("confirmar_contrasena");
    const mensajeErrorContrasena = document.getElementById("error-contrasena");
    const mensajeErrorConfirmar = document.getElementById("error-confirmar");

    formularioCambio.addEventListener("submit", function (event) {
        event.preventDefault();

        const nuevaContrasena = inputNuevaContrasena.value.trim();
        const confirmarContrasena = inputConfirmarContrasena.value.trim();

        let errores = false;

        if (nuevaContrasena.length < 8) {
            mensajeErrorContrasena.textContent = "⚠️ La contraseña debe tener al menos 8 caracteres.";
            errores = true;
        } else if (!/[A-Z]/.test(nuevaContrasena)) {
            mensajeErrorContrasena.textContent = "⚠️ Debe incluir al menos una letra mayúscula.";
            errores = true;
        } else if (!/\d/.test(nuevaContrasena)) {
            mensajeErrorContrasena.textContent = "⚠️ Debe incluir al menos un número.";
            errores = true;
        } else if (!/[!@#$%^&*]/.test(nuevaContrasena)) {
            mensajeErrorContrasena.textContent = "⚠️ Debe incluir al menos un carácter especial.";
            errores = true;
        } else {
            mensajeErrorContrasena.textContent = "";
        }

        if (nuevaContrasena !== confirmarContrasena) {
            mensajeErrorConfirmar.textContent = "⚠️ Las contraseñas no coinciden.";
            errores = true;
        } else {
            mensajeErrorConfirmar.textContent = "";
        }

        if (errores) return;

        formularioCambio.submit();
    });
});
