<?php
// Incluye la conexión
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Verifica conexión
if (!$conexion) {
    die("Error: La conexión a la base de datos no está definida.");
}

// Consulta **30 preguntas aleatorias** de la tabla `preguntas_test_tematicos`
$consulta = "SELECT id, numero_pregunta, pregunta, opcion_a, opcion_b, opcion_c 
             FROM preguntas_test_tematicos 
             ORDER BY RAND() 
             LIMIT 30";
$resultado = $conexion->query($consulta);

if (!$resultado) {
    die("Error en la consulta de preguntas: " . $conexion->error);
}

$preguntas = $resultado->fetch_all(MYSQLI_ASSOC);

// Consulta ayudas correctamente vinculadas con `preguntas_test_tematicos`
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
    <title>Test 1: Señales de tráfico</title>

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

<h1>Test 1: Señales de tráfico</h1>

<div style="text-align:center; font-size:1.2rem; margin-bottom: 1rem;">
    Tiempo restante: <span id="tiempo">30:00</span>
</div>

<div id="marco">
    <img id="imagenPregunta" src="" alt="Imagen de la pregunta">
</div>

<form action="/Proyecto_Integrado_2025/Tecnologias/php/respuestas_usuario/respuestas_usuario_test.php" method="post" id="formularioTest">    
    <input type="hidden" name="tema_id" value="101">

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
let indiceActual = 0;

function cambiarImagen(numeroPregunta) {
    if (numeroPregunta < 1) numeroPregunta = 1;
    const ruta = "http://localhost/Proyecto_Integrado_2025/Tecnologias/img/test_tematicos/tema_1/" + numeroPregunta + ".png";
    document.getElementById("imagenPregunta").src = ruta;
}

function mostrarPregunta(indice) {
    const preguntas = document.querySelectorAll('.pregunta');
    preguntas.forEach((p, i) => {
        p.style.display = i === indice ? 'block' : 'none';
    });

    const numero = preguntas[indice]?.dataset.numero;
    if (numero) cambiarImagen(parseInt(numero));

    const botones = document.querySelectorAll('#cuadrosNavegacion button.cuadro-navegacion');
    botones.forEach((btn, i) => {
        if (i === indice) btn.classList.add('active');
        else btn.classList.remove('active');
    });
}

function siguientePregunta() {
    const preguntas = document.querySelectorAll('.pregunta');
    if (indiceActual < preguntas.length - 1) {
        indiceActual++;
        mostrarPregunta(indiceActual);
    }
}

function anteriorPregunta() {
    if (indiceActual > 0) {
        indiceActual--;
        mostrarPregunta(indiceActual);
    }
}

function eliminarRespuestaVisible() {
    const preguntas = document.querySelectorAll('.pregunta');
    const actual = preguntas[indiceActual];
    if (!actual) return;
    const radios = actual.querySelectorAll('input[type="radio"]');
    radios.forEach(r => r.checked = false);
}

function crearCuadrosNavegacion() {
    const contenedor = document.getElementById('cuadrosNavegacion');
    const preguntas = document.querySelectorAll('.pregunta');

    contenedor.innerHTML = '';

    preguntas.forEach((p, i) => {
        const boton = document.createElement('button');
        boton.type = 'button';
        boton.textContent = i + 1;
        boton.classList.add('cuadro-navegacion');

        boton.addEventListener('click', () => {
            indiceActual = i;
            mostrarPregunta(indiceActual);
        });

        contenedor.appendChild(boton);
    });
}

function toggleAyuda(preguntaId) {
    const divAyuda = document.getElementById('ayuda_' + preguntaId);
    if (divAyuda.style.display === 'block') {
        divAyuda.style.display = 'none';
    } else {
        divAyuda.style.display = 'block';
    }
}

document.addEventListener("DOMContentLoaded", () => {
    crearCuadrosNavegacion();
    mostrarPregunta(indiceActual);
});
</script>

</body>
</html>
