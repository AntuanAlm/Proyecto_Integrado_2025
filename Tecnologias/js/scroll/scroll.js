document.querySelectorAll('a[href^="#"]').forEach(enlace => {
    enlace.addEventListener('click', function(e) {
        e.preventDefault();
        const destino = document.querySelector(this.getAttribute('href'));
        if (destino) {
            destino.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Detectar cuándo las secciones entran en pantalla
const secciones = document.querySelectorAll("section");

const opciones = {
    threshold: 0.1
};

const observador = new IntersectionObserver(function(entradas) {
    entradas.forEach(entrada => {
        if (entrada.isIntersecting) {
            entrada.target.classList.add("visible");
        }
    });
}, opciones);

secciones.forEach(seccion => {
    observador.observe(seccion);
});
