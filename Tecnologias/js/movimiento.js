// Animación para reseñas con IntersectionObserver
const reseñas = document.querySelectorAll('.etiqueta-animada');

const opcionesReseñas = {
    threshold: 0.2
};

const observerReseñas = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('etiqueta-visible');
            observerReseñas.unobserve(entry.target); // Solo se anima una vez
        }
    });
}, opcionesReseñas);

reseñas.forEach(reseña => {
    observerReseñas.observe(reseña);
});
