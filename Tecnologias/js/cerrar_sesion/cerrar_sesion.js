// Este script controla la funcionalidad del menú flotante de sesión
// Espera a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
    const mensajeCerrado = document.querySelector('.sesion-cerrada');
    if (mensajeCerrado) mensajeCerrado.remove();
  }, 4000); // Se oculta a los 4 segundos

});
// Función para cerrar sesión