<?php

include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Verificar que la conexión se estableció correctamente
if (!$conexion) {
    die("Error: La conexión a la base de datos no está definida.");
}

// Preparar la consulta con seguridad para evitar SQL Injection
$consulta = "SELECT id, numero_pregunta, pregunta, opcion_a, opcion_b, opcion_c FROM preguntas_test_tematicos WHERE test_id = ?";
$stmt = $conexion->prepare($consulta);

// Verificar que la preparación de la consulta fue exitosa
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conexion->error);
}

$test_id = 1;
$stmt->bind_param("i", $test_id);
$stmt->execute();
$resultado = $stmt->get_result();


// Verificar que la consulta devolvió resultados
if (!$resultado) {
    die("Error en la ejecución de la consulta: " . $stmt->error);
}

// Extraer preguntas en un array
$preguntas = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test 1: Señales de tráfico</title>

    <!-- links de css -->
    <link rel="stylesheet" href="/Proyecto_Integrado_2025/Tecnologias/css/test_tematicos/test_tematicos.css">

    <!-- Link de las fuentes de google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/Proyecto_Integrado_2025/Tecnologias/img/logo/logo-autoescuela.png" type="image/x-icon">

    <!-- links de js -->
    <script src="/Proyecto_Integrado_2025/Tecnologias/js/temporizador_test/temporizador_test.js"></script>
    <script src="/Proyecto_Integrado_2025/Tecnologias/js/script_preguntas_test/script_pasa_preguntas.js"></script>
    <script src="/Proyecto_Integrado_2025/Tecnologias/js/validaciones_test_respuestas/validaciones_test_respuestas.js"></script>

</head>
<body>

<h1>Test 1: Señales de tráfico</h1>
<div style="text-align:center; font-size:1.2rem; margin-bottom: 1rem;">
    Tiempo restante: <span id="tiempo">30:00</span>
</div>

<div id="marco"></div>

<form action="/Proyecto_Integrado_2025/Tecnologias/php/respuestas_usuario/respuestas_usuario_test.php" method="post" id="formularioTest">    <!-- Campo oculto para enviar el tema_id una sola vez -->
    <input type="hidden" name="tema_id" value="1">

    <?php foreach ($preguntas as $index => $pregunta): ?>
        <div class="pregunta" id="pregunta_<?= $index ?>">
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

function eliminarRespuestaVisible() {
    // Selecciona todos los elementos con la clase 'pregunta' en el documento
    const preguntas = document.querySelectorAll('.pregunta');
    // Inicializa una variable para guardar la pregunta visible (si existe)
    let preguntaVisible = null;

    // Itera sobre cada elemento de 'preguntas'
    preguntas.forEach(p => {
        // Obtiene el valor de la propiedad 'display' del elemento actual
        const visible = window.getComputedStyle(p).display !== 'none';
        // Si el elemento está visible, lo guarda en 'preguntaVisible'
        if (visible) preguntaVisible = p;
    });

    // Si no se encontró ninguna pregunta visible, termina la función
    if (!preguntaVisible) return;

    // Selecciona todos los inputs tipo radio dentro de la pregunta visible
    const radios = preguntaVisible.querySelectorAll('input[type="radio"]');
    // Desmarca (pone en false) todos los radios encontrados
    radios.forEach(radio => radio.checked = false);
}

</script>

</body>
</html>
