document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById("formulario-login");
  
    formulario.addEventListener("submit", function (event) {
      const usuario = formulario.elements["usuario"].value.trim();
      const contraseña = formulario.elements["contrasena"].value.trim();
  
      if (!usuario) {
        alert("El campo de usuario es obligatorio.");
        event.preventDefault();
        return;
      }
  
      if (!contraseña) {
        alert("El campo de contraseña es obligatorio.");
        event.preventDefault();
        return;
      }
  
      if (contraseña.length < 6) {
        alert("La contraseña debe tener al menos 6 caracteres.");
        event.preventDefault();
        return;
      }
    });
  });
  