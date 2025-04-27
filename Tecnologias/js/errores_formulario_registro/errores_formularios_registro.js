document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-datos");

  const errores = {
    nombre: "Por favor, ingresa tu nombre.",
    apellidos: "Por favor, ingresa tus apellidos.",
    dni: "Por favor, adjunta un archivo válido (PDF o imagen).",
    telefono: "Introduce un teléfono válido de 9 dígitos.",
    correo: "Introduce un correo electrónico válido.",
    contrasena: "La contraseña es obligatoria."
  };

  form.addEventListener("submit", (e) => {
    e.preventDefault(); // evita el envío hasta que todo esté validado
    let formularioValido = true;

    [...form.elements].forEach(input => {
      const errorId = input.dataset.error;
      if (errorId) {
        const errorMsg = document.getElementById(errorId);
        errorMsg.textContent = ""; // resetea mensaje previo

        if (!input.checkValidity()) {
          const nombreCampo = input.name;
          errorMsg.textContent = errores[nombreCampo] || "Campo inválido.";
          formularioValido = false;
        }
      }
    });

    if (formularioValido) {
      // Mostrar alerta antes de redirigir
      alert("Formulario válido. Enviando...");

      // Usamos setTimeout para esperar antes de redirigir
      setTimeout(() => {
        window.location.href = "/Tecnologias/html/agradecimiento_pago/agradecimiento_pago.html";
      }, 2000); // espera 2 segundos antes de redirigir
    }
  });
});
