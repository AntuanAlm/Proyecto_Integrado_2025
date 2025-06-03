document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-datos");
  const fechaInput = document.getElementById("fecha_nacimiento");

  // Calcular la fecha mínima permitida (18 años atrás)
  const hoy = new Date();
  const edadMinima = new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate());
  fechaInput.setAttribute("max", edadMinima.toISOString().split("T")[0]);

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
    const fechaNacimiento = new Date(form.fecha_nacimiento.value);

    // Validar nombre real
    if (nombre === "") {
      mostrarError("nombre", "El nombre es obligatorio.");
      errores = true;
    } else if (!esNombreValido(nombre)) {
      mostrarError("nombre", "Introduce un nombre válido.");
      errores = true;
    }

    // Validar apellidos reales
    if (apellidos === "") {
      mostrarError("apellidos", "Los apellidos son obligatorios.");
      errores = true;
    } else if (!esNombreValido(apellidos)) {
      mostrarError("apellidos", "Introduce apellidos válidos.");
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

    // Validar fecha de nacimiento (debe ser válida y mayor de 18 años)
    if (!fechaNacimiento || fechaNacimiento > edadMinima) {
      mostrarError("fecha_nacimiento", "Debes tener al menos 18 años.");
      errores = true;
    }

    if (errores) {
      e.preventDefault(); // Cancelar envío
    }
  });

  function esNombreValido(nombre) {
    // Eliminar espacios extra y convertir a minúsculas
    nombre = nombre.trim().toLowerCase();

    // Verificar longitud (mínimo 2 caracteres, máximo 40)
    if (nombre.length < 2 || nombre.length > 40) return false;

    // Verificar si contiene solo letras y espacios
    if (!/^[a-zA-Záéíóúñü\s]+$/.test(nombre)) return false;

    // Verificar que tenga al menos una vocal
    if (!/[aeiouáéíóúü]/.test(nombre)) return false;

    // Evitar secuencias de consonantes sin vocales
    if (/(?:[^aeiouáéíóúü]{4,})/.test(nombre)) return false;

    return true;
  }

  function mostrarError(idCampo, mensaje) {
    document.getElementById(`error-${idCampo}`).textContent = mensaje;
  }
});
