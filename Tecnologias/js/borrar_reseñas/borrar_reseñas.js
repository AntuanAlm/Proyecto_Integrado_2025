

// Cargar reseñas desde localStorage al cargar la página
      window.onload = function () {
      const reseñasGuardadas = JSON.parse(localStorage.getItem('reseñas')) || [];
      reseñasGuardadas.forEach(reseña => {
        mostrarReseña(reseña.nombre, reseña.texto);
      });
      };

      function agregarReseña() {
      const nombreUsuario = document.getElementById('nombre-usuario').value.trim();
      const reseñaTexto = document.getElementById('nueva-reseña').value.trim();

      if (nombreUsuario === "" || reseñaTexto === "") {
        alert("Por favor, completa todos los campos antes de enviar tu reseña.");
        return;
      }

      // Separar nombre y apellido, ocultar apellido
      const [nombre, ...apellido] = nombreUsuario.split(" ");
      const nombreConAsteriscos = apellido.length > 0 ? `${nombre} ***` : nombre;

      // Guardar en localStorage
      const reseñas = JSON.parse(localStorage.getItem('reseñas')) || [];
      reseñas.push({ nombre: nombreConAsteriscos, texto: reseñaTexto });
      localStorage.setItem('reseñas', JSON.stringify(reseñas));

      // Mostrar en pantalla
      mostrarReseña(nombreConAsteriscos, reseñaTexto);

      // Limpiar campos
      document.getElementById('nombre-usuario').value = "";
      document.getElementById('nueva-reseña').value = "";

      alert("¡Gracias por dejarnos tu opinión!");
      }

      function mostrarReseña(nombre, texto) {
      const nuevaEtiqueta = document.createElement('div');
      nuevaEtiqueta.classList.add("etiqueta-reseña");

      nuevaEtiqueta.innerHTML = `
        <img src="../../img/logo/629383ee30fb025780ee2970.png" alt="reseña-verificada" width="100" height="100">
        <h3>${nombre}</h3>
        <p>${texto}</p>
        <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
      `;

      document.getElementById('etiquetas').appendChild(nuevaEtiqueta);
      }

      function borrarReseñaExistente(button) {
      const etiqueta = button.parentElement;
      const nombre = etiqueta.querySelector('h3').textContent;
      const texto = etiqueta.querySelector('p').textContent;

      // Borrar del DOM
      etiqueta.remove();

      // Borrar del localStorage
      borrarReseña(nombre, texto);
      }

      function borrarReseña(nombre, texto) {
      let reseñas = JSON.parse(localStorage.getItem('reseñas')) || [];
      reseñas = reseñas.filter(reseña => !(reseña.nombre === nombre && reseña.texto === texto));
      localStorage.setItem('reseñas', JSON.stringify(reseñas));
      }

