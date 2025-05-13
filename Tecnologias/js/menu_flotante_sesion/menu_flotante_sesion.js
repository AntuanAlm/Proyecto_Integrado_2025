// Espera a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener("DOMContentLoaded", function () {
    // Obtiene el elemento con el ID "sesionIniciada"
    const sesionDiv = document.getElementById("sesionIniciada");
    // Obtiene el botón con el ID "toggleSesion"
    const botonToggle = document.getElementById("toggleSesion");

    // Después de 3 segundos, reduce el tamaño del contenedor de sesión y muestra el botón de alternar
    setTimeout(() => {
        // Agrega la clase "sesion-reducida" al contenedor de sesión
        sesionDiv.classList.add("sesion-reducida");
        // Muestra el botón de alternar configurando su estilo de display a "block"
        botonToggle.style.display = "block";
    }, 3000);

    // Agrega un evento al botón para alternar el tamaño del contenedor de sesión
    botonToggle.addEventListener("click", () => {
        // Alterna la clase "sesion-reducida" en el contenedor de sesión
        sesionDiv.classList.toggle("sesion-reducida");
    });

    // Agrega un evento para cerrar la ventana de sesión si se hace clic fuera de ella
    document.addEventListener("click", (event) => {
        // Si el clic no ocurrió dentro del contenedor de sesión ni en el botón de alternar
        if (!sesionDiv.contains(event.target) && !botonToggle.contains(event.target)) {
            // Asegura que el contenedor de sesión esté reducido
            sesionDiv.classList.add("sesion-reducida");
        }
    });
});
