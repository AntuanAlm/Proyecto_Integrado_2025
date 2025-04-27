document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("form-datos").addEventListener("submit", function (e) {
      e.preventDefault(); // Prevenir el envío automático
  
      // Función para limpiar errores anteriores
      function limpiarErrores() {
        const errores = document.querySelectorAll(".error-message");
        errores.forEach(error => {
          error.textContent = "";
        });
      }
      limpiarErrores();
  
      // Obtener valores de los campos
      const nombre = document.getElementById("nombre").value.trim();
      const apellidos = document.getElementById("apellidos").value.trim();
      const dni = document.getElementById("dni").files[0];
      const telefono = document.getElementById("telefono").value.trim();
      const correo = document.getElementById("correo").value.trim();
      const contrasena = document.getElementById("contrasena").value.trim();
  
      // Expresiones regulares para validar cada campo
      const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
      const telefonoValido = /^[0-9]{9}$/;
      const correoValido = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
      const contrasenaSegura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
  
      // Función para mostrar errores en el campo correspondiente
      function mostrarError(idCampo, mensaje) {
        const errorElemento = document.getElementById(`error-${idCampo}`);
        if (errorElemento) {
          errorElemento.textContent = mensaje;
          errorElemento.style.color = "red";
        } else {
          console.error(`No se encontró el elemento de error con id "error-${idCampo}"`);
        }
      }
  
      let formularioValido = true;
  
      // Validación de cada campo
      if (!nombre || !soloLetras.test(nombre)) {
        mostrarError("nombre", "Por favor, escribe un nombre válido (solo letras).");
        formularioValido = false;
      }
      if (!apellidos || !soloLetras.test(apellidos)) {
        mostrarError("apellidos", "Por favor, escribe apellidos válidos (solo letras).");
        formularioValido = false;
      }
      if (!dni) {
        mostrarError("dni", "Adjunta un archivo válido (PDF, JPG, JPEG o PNG).");
        formularioValido = false;
      } else {
        const extensionesPermitidas = ["pdf", "jpg", "jpeg", "png"];
        const nombreArchivo = dni.name.split(".").pop().toLowerCase();
        if (!extensionesPermitidas.includes(nombreArchivo)) {
          mostrarError("dni", "Archivo no válido. Solo se aceptan PDF, JPG, JPEG o PNG.");
          formularioValido = false;
        }
      }
      if (!telefono || !telefonoValido.test(telefono)) {
        mostrarError("telefono", "Introduce un teléfono válido (9 dígitos).");
        formularioValido = false;
      }
      if (!correo || !correoValido.test(correo)) {
        mostrarError("correo", "Introduce un correo electrónico válido.");
        formularioValido = false;
      }
      if (!contrasena || !contrasenaSegura.test(contrasena)) {
        mostrarError("contrasena", "La contraseña debe tener mínimo 8 caracteres, una mayúscula, una minúscula, un número y un símbolo.");
        formularioValido = false;
      }
  
      // Depuración en consola
      console.log("Validación del formulario:", formularioValido);
  
      // Si el formulario no es válido, se termina la función sin enviar
      if (!formularioValido) {
        return;
      }
  
      // Si llega aquí, todos los campos son válidos
      const datosCliente = {
        nombre,
        apellidos,
        telefono,
        correo
      };
  
      localStorage.setItem("datosCliente", JSON.stringify(datosCliente));
      alert("Datos validados correctamente. Redirigiendo al pago...");
  
      // Redirigir a la pasarela de pago usando el atributo data-enlace
      const enlace = document.getElementById("enviar-datos").dataset.enlace;
      window.location.href = `${enlace}.html`;
    });
  });
  