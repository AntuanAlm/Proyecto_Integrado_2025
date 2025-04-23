document.addEventListener('DOMContentLoaded', () => {
  const items = document.querySelectorAll('.carrusel-item');
  let indiceActivo = 0;

  function mostrarItem(indice) {
    items.forEach((item, index) => {
      item.classList.toggle('activo', index === indice);
    });
  }

  function siguiente() {
    indiceActivo = (indiceActivo + 1) % items.length;
    mostrarItem(indiceActivo);
  }

  function anterior() {
    indiceActivo = (indiceActivo - 1 + items.length) % items.length;
    mostrarItem(indiceActivo);
  }

  document.getElementById('siguiente').addEventListener('click', siguiente);
  document.getElementById('anterior').addEventListener('click', anterior);

  // Inicializamos
  mostrarItem(indiceActivo);

  // Autoplay
  setInterval(siguiente, 8000);
});
