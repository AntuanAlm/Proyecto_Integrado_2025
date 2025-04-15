document.addEventListener('DOMContentLoaded', () => {
    const imagenes = document.querySelectorAll('[data-src]');
  
    const rutas = {
        reseñas_google: '/Tecnologias/img/logo/629383ee30fb025780ee2970.png',
        coche_autoescuela_grande: '/Tecnologias/img/logo/citroen-auto.png',
        coche_pequeño: '/Tecnologias/img/logo/coche_blanco_auto.png',
        fb: '/Tecnologias/img/logo/facebook.png',
        gmail: '/Tecnologias/img/logo/Gmail_Icon.original.png',
        instagram: '/Tecnologias/img/logo/instagram.png',
        logo_autoescuela: '/Tecnologias/img/logo/logo-autoescuela.png',
        estrellas_google: '/Tecnologias/img/logo/reviews-google.png',
    };

    imagenes.forEach(imagen => {
        const destino = imagen.getAttribute('data-src');
        // Verifica si la ruta existe para el destino
        if (rutas[destino]) {
            imagen.src = rutas[destino]; // Cambia el src dinámicamente
        } else {
            console.warn('Ruta no definida para:', destino);
        }
    });
});
