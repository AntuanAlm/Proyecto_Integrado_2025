document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-datos");

  form.addEventListener("submit", function (e) {
    let errores = false;

    // Limpiar mensajes anteriores
    document.querySelectorAll(".error-message").forEach(p => p.textContent = "");

    // Obtener valores
    const nombre = form.nombre.value.trim();
    const apellidos = form.apellidos.value.trim();
    const dni = form.dni.value.trim();
    const telefono = form.telefono.value.trim();
    const correo = form.correo.value.trim();
    const contrasena = form.contrasena.value;
    const fechaNacimiento = form.fecha_nacimiento.value;

    // Validar nombre
    if (nombre === "") {
      mostrarError("nombre", "El nombre es obligatorio.");
      errores = true;
    }

    // Validar apellidos
    if (apellidos === "") {
      mostrarError("apellidos", "Los apellidos son obligatorios.");
      errores = true;
    }

    // Validar DNI (8 números + 1 letra)
    if (!/^\d{8}[A-Za-z]$/.test(dni)) {
      mostrarError("dni", "El DNI debe tener 8 números y una letra.");
      errores = true;
    }

    // Validar teléfono (9 dígitos)
    if (!/^\d{9}$/.test(telefono)) {
      mostrarError("telefono", "El teléfono debe tener 9 dígitos.");
      errores = true;
    }

    // Validar correo (debe ser un correo válido y de dominio específico)
    if (!/^[^\s@]+@(gmail\.com|hotmail\.com|yahoo\.com|@outlook\.com)$/.test(correo)) {
      mostrarError("correo", "El correo electrónico debe ser de los dominios: @gmail.com, @hotmail.com o @outlook.com.");
      errores = true;
    }

    // Validar contraseña (mínimo 8 caracteres, al menos una mayúscula, un número y un carácter especial)
    if (contrasena.length < 8) {
      mostrarError("contrasena", "La contraseña debe tener al menos 8 caracteres, una mayúscula, al menos un número y un carácter especial.");
      errores = true;
    } else if (!/[A-Z]/.test(contrasena)) {
      mostrarError("contrasena", "La contraseña debe contener al menos una letra mayúscula.");
      errores = true;
    } else if (!/\d/.test(contrasena)) {
      mostrarError("contrasena", "La contraseña debe contener al menos un número.");
      errores = true;
    } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(contrasena)) {
      mostrarError("contrasena", "La contraseña debe contener al menos un carácter especial.");
      errores = true;
    }

    // Validar fecha de nacimiento (debe ser válida)
    if (fechaNacimiento === "") {
      mostrarError("fecha_nacimiento", "La fecha de nacimiento es obligatoria.");
      errores = true;
    }

    if (errores) {
      e.preventDefault(); // Cancelar envío
    }
  });

  function mostrarError(idCampo, mensaje) {
    document.getElementById(`error-${idCampo}`).textContent = mensaje;
  }
});
