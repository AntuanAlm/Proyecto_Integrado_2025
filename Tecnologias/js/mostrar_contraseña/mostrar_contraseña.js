function mostrarContraseña() {
    const inputContrasena = document.getElementById('contrasena');
    const botonAlternar = document.getElementById('mostrar-contrasena');
    if (inputContrasena.type === 'password') {
        inputContrasena.type = 'text';
        botonAlternar.textContent = 'Ocultar';
    } else {
        inputContrasena.type = 'password';
        botonAlternar.textContent = 'Mostrar';
    }
}

// Agregar el event listener para llamar a la función
document.getElementById('mostrar-contrasena').addEventListener('click', mostrarContraseña);
