<?php
// Incluye la conexión
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Verifica conexión
if (!$conexion) {
    die("Error: La conexión a la base de datos no está definida.");
}

// Consulta preguntas
$consulta = "SELECT id, numero_pregunta, pregunta, opcion_a, opcion_b, opcion_c FROM preguntas_test_tematicos WHERE tema_id = 1";
$resultado = $conexion->query($consulta);

if (!$resultado) {
    die("Error en la consulta de preguntas: " . $conexion->error);
}

$preguntas = $resultado->fetch_all(MYSQLI_ASSOC);

// Consulta ayudas
$consulta_ayuda = "SELECT pregunta_id, texto_ayuda FROM ayudas";
$resultado_ayuda = $conexion->query($consulta_ayuda);

$ayudas = [];
if ($resultado_ayuda) {
    while ($fila = $resultado_ayuda->fetch_assoc()) {
        $ayudas[$fila['pregunta_id']] = $fila['texto_ayuda'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test 1: Señales de tráfico 📚</title>

    <link rel="stylesheet" href="/Proyecto_Integrado_2025/Tecnologias/css/test_tematicos/test_tematicos.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans&family=Poppins&family=Roboto&family=Winky+Sans&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/Proyecto_Integrado_2025/Tecnologias/img/logo/logo-autoescuela.png" type="image/x-icon">

    <script src="/Proyecto_Integrado_2025/Tecnologias/js/temporizador_test/temporizador_test.js"></script>
    <script src="/Proyecto_Integrado_2025/Tecnologias/js/validaciones_test_respuestas/validaciones_test_respuestas.js"></script>

</head>
<body>

<button class="boton-cerrar" onclick="if(confirm('Vas a volver al menú de test temáticos y no se va guardar el intento. ¿Deseas continuar?')){location.href='../../../../Tecnologias/html/test_tematicos/menu_test_tematicos.html';}" aria-label="Cerrar">×</button>

<h1>Test 1: Señales de tráfico 📚</h1>

<div style="text-align:center; font-size:1.2rem; margin-bottom: 1rem;">
    Tiempo restante: <span id="tiempo">30:00</span>
</div>

<div id="marco">
    <img id="imagenPregunta" src="" alt="Imagen de la pregunta">
</div>

<form action="/Proyecto_Integrado_2025/Tecnologias/php/respuestas_usuario/respuestas_usuario_test.php" method="post" id="formularioTest">    
    <input type="hidden" name="tema_id" value="1">

    <?php foreach ($preguntas as $index => $pregunta): ?>
        <div class="pregunta" id="pregunta_<?= $index ?>" data-numero="<?= $pregunta['numero_pregunta'] ?>" style="<?= $index === 0 ? '' : 'display:none;' ?>">
            <h3>Pregunta <?= $pregunta["numero_pregunta"] ?>: <?= htmlspecialchars($pregunta["pregunta"]) ?></h3>

            <div class="opciones">
                <label>
                    <input type="radio" name="respuesta[<?= $pregunta["id"] ?>]" value="A">
                    A. <?= htmlspecialchars($pregunta["opcion_a"]) ?>
                </label>
                <label>
                    <input type="radio" name="respuesta[<?= $pregunta["id"] ?>]" value="B">
                    B. <?= htmlspecialchars($pregunta["opcion_b"]) ?>
                </label>
                <label>
                    <input type="radio" name="respuesta[<?= $pregunta["id"] ?>]" value="C">
                    C. <?= htmlspecialchars($pregunta["opcion_c"]) ?>
                </label>
            </div>

            <?php if (isset($ayudas[$pregunta['id']])): ?>
                <button type="button" class="boton-ayuda" onclick="toggleAyuda(<?= $pregunta['id'] ?>)">Mostrar ayuda</button>
                <div id="ayuda_<?= $pregunta['id'] ?>" class="ayuda-texto"><?= htmlspecialchars($ayudas[$pregunta['id']]) ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <div class="nav-buttons">
        <button type="button" onclick="anteriorPregunta()">Anterior</button>
        <button type="button" onclick="siguientePregunta()">Siguiente</button>
        <button type="button" onclick="eliminarRespuestaVisible()">Eliminar respuesta</button>
    </div>

    <div class="navegacion" id="cuadrosNavegacion"></div>

    <div style="text-align:center; margin-top:2rem;">
        <button type="submit">Finalizar test</button>
    </div>
</form>

<script>
// Variable para saber en qué pregunta estamos
let indiceActual = 0;

// Cambia la imagen según el número de la pregunta
function cambiarImagen(numeroPregunta) {
    // Si el número es menor que 1, lo pone a 1
    if (numeroPregunta < 1) numeroPregunta = 1;
    // Crea la ruta de la imagen usando el número de la pregunta
    const ruta = "http://localhost/Proyecto_Integrado_2025/Tecnologias/img/test_tematicos/tema_1/" + numeroPregunta + ".png";
    // Cambia la imagen en la página
    document.getElementById("imagenPregunta").src = ruta;
}

// Muestra solo la pregunta que toca y oculta las demás
function mostrarPregunta(indice) {
    // Busca todas las preguntas
    const preguntas = document.querySelectorAll('.pregunta');
    // Recorre todas las preguntas
    preguntas.forEach((p, i) => {
        // Solo muestra la pregunta actual, oculta las otras
        p.style.display = i === indice ? 'block' : 'none';
    });

    // Busca el número de la pregunta actual
    const numero = preguntas[indice]?.dataset.numero;
    // Si hay número, cambia la imagen
    if (numero) cambiarImagen(parseInt(numero));

    // Busca todos los botones de navegación
    const botones = document.querySelectorAll('#cuadrosNavegacion button.cuadro-navegacion');
    // Recorre los botones
    botones.forEach((btn, i) => {
        // Marca el botón de la pregunta actual
        if (i === indice) btn.classList.add('active');
        // Quita la marca a los demás
        else btn.classList.remove('active');
    });
}

// Pasa a la siguiente pregunta si no es la última
function siguientePregunta() {
    // Busca todas las preguntas
    const preguntas = document.querySelectorAll('.pregunta');
    // Si no estamos en la última pregunta
    if (indiceActual < preguntas.length - 1) {
        // Suma uno al índice
        indiceActual++;
        // Muestra la nueva pregunta
        mostrarPregunta(indiceActual);
    }
}

// Vuelve a la pregunta anterior si no es la primera
function anteriorPregunta() {
    // Si no estamos en la primera pregunta
    if (indiceActual > 0) {
        // Resta uno al índice
        indiceActual--;
        // Muestra la pregunta anterior
        mostrarPregunta(indiceActual);
    }
}

// Borra la respuesta marcada en la pregunta actual
function eliminarRespuestaVisible() {
    // Busca todas las preguntas
    const preguntas = document.querySelectorAll('.pregunta');
    // Busca la pregunta actual
    const actual = preguntas[indiceActual];
    // Si no hay pregunta, sale
    if (!actual) return;
    // Busca todos los radios (opciones) de la pregunta
    const radios = actual.querySelectorAll('input[type="radio"]');
    // Desmarca todas las opciones
    radios.forEach(r => r.checked = false);
}

// Crea los botones para navegar entre preguntas
function crearCuadrosNavegacion() {
    // Busca el contenedor de los botones
    const contenedor = document.getElementById('cuadrosNavegacion');
    // Busca todas las preguntas
    const preguntas = document.querySelectorAll('.pregunta');

    // Limpia el contenedor
    contenedor.innerHTML = '';

    // Recorre todas las preguntas
    preguntas.forEach((p, i) => {
        // Crea un botón para cada pregunta
        const boton = document.createElement('button');
        boton.type = 'button';
        boton.textContent = i + 1; // El número del botón
        boton.classList.add('cuadro-navegacion');

        // Cuando se hace clic, muestra esa pregunta
        boton.addEventListener('click', () => {
            indiceActual = i;
            mostrarPregunta(indiceActual);
        });

        // Añade el botón al contenedor
        contenedor.appendChild(boton);
    });
}

// Muestra u oculta la ayuda de una pregunta
function toggleAyuda(preguntaId) {
    // Busca el div de la ayuda de esa pregunta
    const divAyuda = document.getElementById('ayuda_' + preguntaId);
    // Si está visible, la oculta
    if (divAyuda.style.display === 'block') {
        divAyuda.style.display = 'none';
    } else {
        // Si está oculta, la muestra
        divAyuda.style.display = 'block';
    }
}

// Cuando la página termina de cargar
document.addEventListener("DOMContentLoaded", () => {
    // Crea los botones de navegación
    crearCuadrosNavegacion();
    // Muestra la primera pregunta
    mostrarPregunta(indiceActual);
});
</script>

</body>
</html>
