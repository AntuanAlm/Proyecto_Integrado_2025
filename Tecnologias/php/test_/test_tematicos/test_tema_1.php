<?php
include("../../conexion/conexion.php");

// Preparar la consulta con seguridad para evitar SQL Injection
$consulta = "SELECT numero_pregunta, pregunta, opcion_a, opcion_b, opcion_c FROM preguntas_test_tematicos WHERE test_id = ?";
$stmt = $conexion->prepare($consulta);
$test_id = 1;
$stmt->bind_param("i", $test_id);
$stmt->execute();
$resultado = $stmt->get_result();

// Extraer preguntas en un array
$preguntas = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test 1: Señales de tráfico</title>

    <!-- links de css -->
    <link rel="stylesheet" href="../../../css/test_tematicos/test_tematicos.css">

    <!-- JS -->
    <script src="../../../js/temporizador_test/temporizador_test.js"></script>
    <script src="../../../js/script_preguntas_test/script_pasa_preguntas.js"></script>


    
</head>
<body>

<h1>Test 1: Señales de tráfico</h1>
<div style="text-align:center; font-size:1.2rem; margin-bottom: 1rem;">
    Tiempo restante: <span id="tiempo">30:00</span>
</div>

    <div id="marco">
        
    </div>


<form action="../../php/test_/test_tematicos/resultado.php" method="post" id="formularioTest">
    <?php foreach ($preguntas as $index => $pregunta): ?>
        <div class="pregunta" id="pregunta_<?= $index ?>">
            <h3>Pregunta <?= $pregunta["numero_pregunta"] ?>: <?= htmlspecialchars($pregunta["pregunta"]) ?></h3>
            <div class="opciones">
                <label><input type="radio" name="respuesta[<?= $pregunta["numero_pregunta"] ?>]" value="A" required> A. <?= htmlspecialchars($pregunta["opcion_a"]) ?></label>
                <label><input type="radio" name="respuesta[<?= $pregunta["numero_pregunta"] ?>]" value="B"> B. <?= htmlspecialchars($pregunta["opcion_b"]) ?></label>
                <label><input type="radio" name="respuesta[<?= $pregunta["numero_pregunta"] ?>]" value="C"> C. <?= htmlspecialchars($pregunta["opcion_c"]) ?></label>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="nav-buttons">
        <button type="button" onclick="anteriorPregunta()">Anterior</button>
        <button type="button" onclick="siguientePregunta()">Siguiente</button>
    </div>

    <div class="navegacion" id="cuadrosNavegacion"></div>

    <div style="text-align:center; margin-top:2rem;">
        <button type="submit">Enviar respuestas</button>
    </div>
</form>
</body>
</html>
