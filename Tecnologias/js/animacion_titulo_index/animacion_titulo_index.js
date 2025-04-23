// Animación del título en la sección de tecnologías
  document.addEventListener("DOMContentLoaded", () => {
    const subtitulo = document.getElementById("subtitulo-etiquetas");

    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          subtitulo.classList.add("visible");
        }
      },
      {
        threshold: 0.4,
      }
    );

    if (subtitulo) observer.observe(subtitulo);
  });

