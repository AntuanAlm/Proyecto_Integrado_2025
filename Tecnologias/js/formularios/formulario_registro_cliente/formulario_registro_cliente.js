document.getElementById("form-datos").addEventListener("submit", function (e) {
    e.preventDefault(); // Evitar que el formulario se envíe automáticamente

    // Obtener valores de los campos
    const nombre = document.getElementById("nombre").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const dni = document.getElementById("dni").files[0]; // Archivo seleccionado
    const telefono = document.getElementById("telefono").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();

    // Expresiones regulares
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/; // Solo letras y espacios
    const telefonoValido = /^[0-9]{9}$/; // Teléfono con 9 dígitos
    const correoValido = /^[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+$/; // Formato de correo
    const contrasenaSegura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/; // Contraseña segura

    // Función para mostrar mensajes de error
    function mostrarError(idCampo, mensaje) {
        const errorElemento = document.getElementById(`error-${idCampo}`);
        errorElemento.textContent = mensaje;
        errorElemento.style.color = "red";
    }

    // Limpiar mensajes de error
    function limpiarErrores() {
        const errores = document.querySelectorAll(".error-message");
        errores.forEach(error => {
            error.textContent = "";
        });
    }

    limpiarErrores(); // Limpiar errores previos

    // Validaciones
    let formularioValido = true;

    if (!nombre || !soloLetras.test(nombre)) {
        mostrarError("nombre", "Por favor, introduce un nombre válido (solo letras).");
        formularioValido = false;
    }

    if (!apellidos || !soloLetras.test(apellidos)) {
        mostrarError("apellidos", "Por favor, introduce apellidos válidos (solo letras).");
        formularioValido = false;
    }

    if (!dni) {
        mostrarError("dni", "Por favor, adjunta un archivo válido (PDF, JPG, JPEG o PNG).");
        formularioValido = false;
    } else {
        const extensionesPermitidas = ["pdf", "jpg", "jpeg", "png"];
        const nombreArchivo = dni.name.split('.').pop().toLowerCase();
        if (!extensionesPermitidas.includes(nombreArchivo)) {
            mostrarError("dni", "El archivo debe ser un PDF, JPG, JPEG o PNG.");
            formularioValido = false;
        }
    }

    if (!telefono || !telefonoValido.test(telefono)) {
        mostrarError("telefono", "Por favor, introduce un teléfono válido (9 dígitos).");
        formularioValido = false;
    }

    if (!correo || !correoValido.test(correo)) {
        mostrarError("correo", "Por favor, introduce un correo electrónico válido.");
        formularioValido = false;
    }

    if (!contrasena || !contrasenaSegura.test(contrasena)) {
        mostrarError("contrasena", "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.");
        formularioValido = false;
    }

    // Si el formulario no es válido, detenemos el proceso
    if (!formularioValido) {
        return;
    }

    // Almacenamos los datos (sin contraseña) en localStorage
    const datosCliente = {
        nombre,
        apellidos,
        telefono,
        correo
    };

    localStorage.setItem("datosCliente", JSON.stringify(datosCliente));

    // Confirmación visual
    alert("Datos validados y enviados correctamente. ¡Gracias!");

    // Aquí podrías redirigir al usuario si es necesario
    // window.location.href = "siguiente_pagina.html";
});
