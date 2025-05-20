document.addEventListener('DOMContentLoaded', () => {
    const imagenes = document.querySelectorAll('[data-src]');

    const rutas = {
        reseñas_google: '../../img/logo/629383ee30fb025780ee2970.png',
        coche_autoescuela_grande: '../../img/logo/citroen-auto.png',
        coche_pequeño: '../../img/logo/coche_blanco_auto.png',
        fb: '../../img/logo/facebook.png',
        gmail: '../../img/logo/Gmail_Icon.original.png',
        instagram: '../../img/logo/instagram.png',
        logo_autoescuela: '../../img/logo/logo-autoescuela.png',
        estrellas_google: '../../img/logo/reviews-google.png',
        profesor:'../../img/logo/profesor_auto.png',
        profesora:'../../img/logo/profesora_auto.png',
        gif_estadisticas:'../../img/gif/estadisticas.gif',
        gif_compras:'../../img/gif/compras.gif',
        gif_test:'../../img/gif/test.gif',
    };
    

    if (imagenes.length === 0) {
        console.warn('No se encontraron elementos con el atributo [data-src].');
    } else {
        imagenes.forEach(imagen => {
            const destino = imagen.getAttribute('data-src');
            if (destino && rutas[destino]) {
                imagen.src = rutas[destino];
                console.log(`Ruta asignada: ${rutas[destino]} para ${destino}`);
            } else if (!destino) {
                console.error('El atributo data-src está ausente o vacío en un elemento.');
            } else {
                console.warn(`Ruta no definida para: ${destino}`);
            }
        });
    }
});
