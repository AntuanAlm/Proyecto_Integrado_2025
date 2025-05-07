// script_pasa_preguntas.js
// Este script permite navegar entre preguntas en un test de manera sencilla y visual.

document.addEventListener("DOMContentLoaded", function() { // Se asegura de que el código se ejecute después de que el DOM esté completamente cargado.
    console.log('Script cargado correctamente');


    // Selecciona todas las preguntas del test y las almacena en una variable llamada "preguntas".
    let preguntas = document.querySelectorAll('.pregunta');
    let total = preguntas.length; // Almacena el número total de preguntas.
    let actual = 0; // Inicializa el índice de la pregunta actual en 0.

    // Función que muestra una pregunta específica basándose en su índice.
    function mostrarPregunta(index) {
        // Cambia la clase de cada pregunta para mostrar solo la activa.
        // p, i es cada pregunta y su índice respectivamente.
        preguntas.forEach((p, i) => p.classList.toggle('active', i === index));

        // Cambia la clase de cada "cuadro" (navegación) para resaltar el cuadro correspondiente a la pregunta activa.
        // c, i es cada cuadro y su índice respectivamente.
        // Se utiliza el método toggle para agregar o quitar la clase "active" dependiendo de si el índice coincide con el índice actual.
        document.querySelectorAll('.cuadro').forEach((c, i) => c.classList.toggle('active', i === index));

        // Actualiza el índice de la pregunta actualmente visible.
        actual = index;
    }

    // Función que muestra la siguiente pregunta si no estamos en la última pregunta.
    function siguientePregunta() {
        if (actual < total - 1) mostrarPregunta(actual + 1); // Solo avanza si no es la última pregunta.
    }

    // Función que muestra la pregunta anterior si no estamos en la primera pregunta.
    function anteriorPregunta() {
        if (actual > 0) mostrarPregunta(actual - 1); // Solo retrocede si no es la primera pregunta.
    }

    // Función para crear los cuadros de navegación (números) que permiten saltar a una pregunta específica.
    function crearCuadros() {
        const nav = document.getElementById("cuadrosNavegacion"); // Selecciona el contenedor donde se agregarán los cuadros de navegación.

        // Crea un cuadro para cada pregunta.
        for (let i = 0; i < total; i++) {
            const div = document.createElement("div"); // Crea un nuevo elemento div.
            div.classList.add("cuadro"); // Le agrega la clase "cuadro".
            div.textContent = i + 1; // Establece el número del cuadro (empezando desde 1).
            
            // Agrega un event listener al cuadro para mostrar la pregunta correspondiente cuando se haga clic.
            div.addEventListener("click", () => mostrarPregunta(i));
            
            // Agrega el cuadro al contenedor de navegación.
            nav.appendChild(div);
        }
    }

    // Llama a la función para crear los cuadros de navegación.
    crearCuadros();

    // Muestra la primera pregunta (índice 0) cuando se carga la página.
    mostrarPregunta(0);

    // Expone las funciones al ámbito global para que los botones las puedan llamar
    // Se pueden llamar desde el HTML o desde otros scripts.
    // Esto es útil si tienes botones en tu HTML que llaman a estas funciones directamente.
    window.siguientePregunta = siguientePregunta;
    window.anteriorPregunta = anteriorPregunta;

});
