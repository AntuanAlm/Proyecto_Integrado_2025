document.addEventListener("DOMContentLoaded", function() {
    const botonAlternar = document.getElementById('mostrar-contrasena');
    const inputContrasena = document.getElementById('contrasena');

    if (botonAlternar && inputContrasena) {
        botonAlternar.addEventListener('click', function() {
            if (inputContrasena.type === 'password') {
                inputContrasena.type = 'text';
                botonAlternar.textContent = 'Ocultar';
            } else {
                inputContrasena.type = 'password';
                botonAlternar.textContent = 'Mostrar';
            }
        });
    } else {
        console.error("El botón o el campo de contraseña no se encontraron en el DOM.");
    }
});
