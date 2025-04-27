// Agrega un evento al formulario con id 'formulario-contacto' que se ejecuta al enviarlo
document.getElementById('formulario-contacto').addEventListener('submit', function(event) {
    // Obtiene el valor del campo 'nombre' y elimina espacios en blanco al inicio y al final
    const nombre = document.getElementById('nombre').value.trim();
    // Obtiene el valor del campo 'apellidos' y elimina espacios en blanco al inicio y al final
    const apellidos = document.getElementById('apellidos').value.trim();
    // Obtiene el valor del campo 'email' y elimina espacios en blanco al inicio y al final
    const email = document.getElementById('email').value.trim();
    // Obtiene el valor del campo 'telefono' y elimina espacios en blanco al inicio y al final
    const telefono = document.getElementById('telefono').value.trim();
    // Obtiene el valor del campo 'asunto'
    const asunto = document.getElementById('asunto').value;
    // Obtiene el valor del campo 'mensaje' y elimina espacios en blanco al inicio y al final
    const mensaje = document.getElementById('mensaje').value.trim();

    // Crea un array vacío para almacenar los mensajes de error
    let errores = [];

    // Verifica si el nombre tiene al menos 2 caracteres
    if (nombre.length < 2) {
        errores.push("El nombre debe tener al menos 2 caracteres.");
    }

    // Verifica si los apellidos tienen al menos 2 caracteres
    if (apellidos.length < 2) {
        errores.push("Los apellidos deben tener al menos 2 caracteres.");
    }

    // Expresión regular para validar el formato del email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    // Verifica si el email tiene un formato válido
    if (!emailRegex.test(email)) {
        errores.push("Introduce un email válido.");
    }

    // Expresión regular para validar que el teléfono tenga exactamente 9 dígitos
    const telefonoRegex = /^[0-9]{9}$/;
    // Verifica si el teléfono cumple con el formato esperado
    if (!telefonoRegex.test(telefono)) {
        errores.push("El teléfono debe tener 9 dígitos.");
    }

    // Verifica si se seleccionó un asunto
    if (asunto === "") {
        errores.push("Selecciona un asunto.");
    }

    // Verifica si el mensaje tiene al menos 10 caracteres
    if (mensaje.length < 10) {
        errores.push("El mensaje debe tener al menos 10 caracteres.");
    }

    // Si hay errores, evita que se envíe el formulario y muestra los errores en una alerta
    if (errores.length > 0) {
        event.preventDefault(); // Evita que se envíe el formulario
        alert("Corrige los siguientes errores:\n\n" + errores.join("\n"));
    }
});
