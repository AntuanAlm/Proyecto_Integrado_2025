document.addEventListener('DOMContentLoaded', function () {
  const formulario = document.getElementById('formulario-login');

  if (formulario) {
    formulario.addEventListener('submit', async function (e) {
      e.preventDefault();

      // Limpiar errores anteriores
      document.getElementById('error-usuario').textContent = '';
      document.getElementById('error-contrasena').textContent = '';

      const usuario = document.getElementById('usuario').value.trim();
      const contrasena = document.getElementById('contrasena').value.trim();

      let hayError = false;

      if (!usuario) {
        document.getElementById('error-usuario').textContent = '⚠️ El usuario es obligatorio.';
        hayError = true;
      }

      if (!contrasena) {
        document.getElementById('error-contrasena').textContent = '⚠️ La contraseña es obligatoria.';
        hayError = true;
      }

      if (hayError) return;

      try {
        const respuesta = await fetch('../../php/verificar_login_usuarios/verificar_login_usuarios.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ usuario, contrasena })
        });

        const datos = await respuesta.json();

        if (datos.success) {
          window.location.href = '../../html/area_alumnos/area_alumnos.php';
        } else {
          if (datos.error === 'usuario') {
            document.getElementById('error-usuario').textContent = '⚠️ Usuario no válido.';
          } else if (datos.error === 'contrasena') {
            document.getElementById('error-contrasena').textContent = '⚠️ Contraseña incorrecta.';
          } else {
            document.getElementById('error-contrasena').textContent = '⚠️ Usuario o contraseña incorrectos.';
          }
        }
      } catch (error) {
        console.error('Error al verificar login:', error);
        document.getElementById('error-contrasena').textContent = '⚠️ Error de conexión con el servidor.';
      }
    });
  }
});
