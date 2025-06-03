// Espera a que el DOM esté completamente cargado antes de ejecutar el código
document.addEventListener("DOMContentLoaded", function () {
    // Cargar reseñas desde localStorage al cargar la página
    const reseñasGuardadas = JSON.parse(localStorage.getItem("reseñas")) || [];
    // Muestra cada reseña guardada en pantalla
    reseñasGuardadas.forEach(reseña => {
        mostrarReseña(reseña.nombre, reseña.texto);
    });

    // Añade evento de clic a todos los botones de borrar existentes
    document.querySelectorAll(".boton-borrar").forEach(boton => {
        boton.addEventListener("click", function () {
            borrarReseñaExistente(this);
        });
    });
});

// Lista de palabras prohibidas para filtrar reseñas inapropiadas
const palabrasProhibidas = [
    // Masculino singular
    "tonto", "gilipollas", "subnormal", "idiota", "imbécil", "estúpido", "inútil", "payaso", "capullo", "bobo",
    "cretino", "tarado", "zoquete", "burro", "bestia", "patán", "necio", "memo", "pelmazo", "cenutrio", "majadero",
    "miserable", "asqueroso", "cerdo", "baboso", "maldito", "malnacido", "desgraciado", "cabron", "hijo de puta", "perro",
    // Masculino plural
    "tontos", "gilipollas", "subnormales", "idiotas", "imbéciles", "estúpidos", "inútiles", "payasos", "capullos", "bobos",
    "cretinos", "tarados", "zoquetes", "burros", "bestias", "patanes", "necios", "memos", "pelmazos", "cenutrios", "majaderos",
    "miserables", "asquerosos", "cerdos", "babosos", "malditos", "malnacidos", "desgraciados", "cabrones", "hijos de puta", "perros",
    // Femenino singular
    "tonta", "gilipollas", "subnormal", "idiota", "imbécil", "estúpida", "inútil", "payasa", "capulla", "boba",
    "cretina", "tarada", "zoqueta", "burra", "bestia", "patana", "necia", "mema", "pelmaza", "cenutria", "majadera",
    "miserable", "asquerosa", "cerda", "babosa", "maldita", "malnacida", "desgraciada", "cabrona", "hija de puta", "perra",
];

// Función para agregar una nueva reseña
function agregarReseña() {
    // Obtiene el nombre del usuario y el texto de la reseña desde los inputs
    const nombreUsuario = document.getElementById("nombre-usuario").value.trim();
    const reseñaTexto = document.getElementById("nueva-reseña").value.trim();

    // Verifica que ambos campos estén completos
    if (nombreUsuario === "" || reseñaTexto === "") {
        alert("Por favor, completa todos los campos antes de enviar tu reseña.");
        return;
    }

    // Verifica si la reseña contiene palabras prohibidas
    if (contienePalabrotas(reseñaTexto)) {
        alert("Tu reseña contiene palabras inapropiadas. Inténtalo de nuevo.");
        return;
    }

    // Separa el nombre y el apellido, y oculta el apellido con asteriscos
    const [nombre, ...apellido] = nombreUsuario.split(" ");
    const nombreConAsteriscos = apellido.length > 0 ? `${nombre} ***` : nombre;

    // Recupera las reseñas guardadas, agrega la nueva y guarda en localStorage
    const reseñas = JSON.parse(localStorage.getItem("reseñas")) || [];
    reseñas.push({ nombre: nombreConAsteriscos, texto: reseñaTexto });
    localStorage.setItem("reseñas", JSON.stringify(reseñas));

    // Muestra la nueva reseña en pantalla
    mostrarReseña(nombreConAsteriscos, reseñaTexto);

    // Limpia los campos del formulario
    document.getElementById("nombre-usuario").value = "";
    document.getElementById("nueva-reseña").value = "";

    alert("¡Gracias por dejarnos tu opinión!");
}

// Función para mostrar una reseña en el DOM
function mostrarReseña(nombre, texto) {
    // Crea un nuevo div para la reseña
    const nuevaEtiqueta = document.createElement("div");
    nuevaEtiqueta.classList.add("etiqueta-reseña");

    // Genera un id único para el texto de la reseña
    const idReseña = `texto-reseña-${Date.now()}`;

    // Inserta el contenido HTML de la reseña, incluyendo botones de borrar y editar
    nuevaEtiqueta.innerHTML = `
        <img src="../../img/logo/629383ee30fb025780ee2970.png" alt="reseña-verificada" width="100" height="100">
        <h3>${nombre}</h3>
        <p id="${idReseña}">${texto}</p>
        <button class="boton-borrar" onclick="borrarReseñaExistente(this)">❌ Borrar</button>
        <button class="boton-editar" onclick="editarReseña('${idReseña}')">✏️ Editar</button>
    `;

    // Añade la reseña al contenedor de reseñas en el DOM
    document.getElementById("etiquetas").appendChild(nuevaEtiqueta);
}

// Función para editar una reseña existente
function editarReseña(idReseña) {
    // Obtiene el elemento del texto de la reseña a editar
    const reseña = document.getElementById(idReseña);
    // Solicita al usuario el nuevo texto de la reseña
    let nuevoTexto = prompt("Edita la reseña:", reseña.textContent);

    // Si el usuario no cancela y el texto no está vacío
    if (nuevoTexto !== null && nuevoTexto.trim() !== "") {
        // Verifica si el nuevo texto contiene palabras prohibidas
        if (contienePalabrotas(nuevoTexto)) {
            alert("Tu reseña contiene palabras inapropiadas. Inténtalo de nuevo.");
            return;
        }

        // Actualiza el texto en el DOM
        reseña.textContent = nuevoTexto;

        // Actualiza el texto en localStorage
        actualizarReseña(idReseña, nuevoTexto);
    }
}

// Función para actualizar el texto de una reseña en localStorage
function actualizarReseña(idReseña, nuevoTexto) {
    // Recupera las reseñas guardadas
    let reseñas = JSON.parse(localStorage.getItem("reseñas")) || [];
    
    // Busca la reseña correspondiente y actualiza su texto
    reseñas = reseñas.map(reseña => {
        if (document.getElementById(idReseña).textContent === reseña.texto) {
            return { ...reseña, texto: nuevoTexto };
        }
        return reseña;
    });

    // Guarda las reseñas actualizadas en localStorage
    localStorage.setItem("reseñas", JSON.stringify(reseñas));
}

// Función para borrar una reseña existente (desde el botón)
function borrarReseñaExistente(button) {
    // Pide confirmación al usuario antes de borrar
    let confirmacion = confirm("¿Estás seguro de que deseas borrar esta reseña?");
    if (confirmacion) {
        // Obtiene el div de la reseña y sus datos
        const etiqueta = button.parentElement;
        const nombre = etiqueta.querySelector("h3").textContent.trim();
        const texto = etiqueta.querySelector("p").textContent.trim();

        // Elimina la reseña del DOM
        etiqueta.remove();

        // Elimina la reseña de localStorage
        borrarReseña(nombre, texto);
    }
}

// Función para borrar una reseña de localStorage
function borrarReseña(nombre, texto) {
    // Recupera las reseñas guardadas
    let reseñas = JSON.parse(localStorage.getItem("reseñas")) || [];
    // Filtra la reseña que coincide con nombre y texto
    let nuevasReseñas = reseñas.filter(reseña => reseña.nombre !== nombre || reseña.texto !== texto);
    // Guarda el nuevo array en localStorage
    localStorage.setItem("reseñas", JSON.stringify(nuevasReseñas));
}

// Función para detectar si un texto contiene palabras prohibidas
function contienePalabrotas(texto) {
    // Devuelve true si alguna palabra prohibida está en el texto
    return palabrasProhibidas.some(palabra => texto.toLowerCase().includes(palabra));
}
