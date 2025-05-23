<?php
session_start();
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Verificar autenticación del usuario
if (!isset($_SESSION["usuario"]["id"])) {
    die("Error: Usuario no autenticado.");
}

$usuario_id = intval($_SESSION["usuario"]["id"]);

// Obtener número de intento actual del usuario
$consulta_intento = "SELECT IFNULL(MAX(intento), 0) + 1 AS nuevo_intento FROM respuestas_usuario WHERE usuario_id = ?";
$stmt_intento = $conexion->prepare($consulta_intento);
$stmt_intento->bind_param("i", $usuario_id);
$stmt_intento->execute();
$resultado_intento = $stmt_intento->get_result();
$intento_actual = intval($resultado_intento->fetch_assoc()["nuevo_intento"]);

// Comprobar si se envió el formulario y `tema_id`
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tema_id"])) {
    $tema_id = intval($_POST["tema_id"]);
    $respuestas_procesadas = 0;
    
    foreach ($_POST["respuesta"] ?? [] as $pregunta_id => $respuesta_usuario) {
        $pregunta_id = intval($pregunta_id);

        // Validar que la pregunta existe antes de procesarla
        $consulta = "SELECT respuesta_correcta, tema_id FROM preguntas_test_tematicos WHERE id = ?";
        $stmt = $conexion->prepare($consulta);
        $stmt->bind_param("i", $pregunta_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        if (!$fila) {
            continue; // Ignora preguntas inexistentes
        }

        $respuesta_correcta = $fila["respuesta_correcta"];
        $tema_id = intval($fila["tema_id"]);
        $es_correcta = ($respuesta_usuario === $respuesta_correcta) ? 1 : 0;
        $fecha_respuesta = date("Y-m-d H:i:s");

        // Insertar respuesta del usuario
        $insert = "INSERT INTO respuestas_usuario (usuario_id, pregunta_id, respuesta, es_correcta, fecha_respuesta, intento, tema_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conexion->prepare($insert);
        $stmt_insert->bind_param("iisdssi", $usuario_id, $pregunta_id, $respuesta_usuario, $es_correcta, $fecha_respuesta, $intento_actual, $tema_id);
        $stmt_insert->execute();

        if (!$es_correcta) {
            // Insertar el error en errores_usuario
            $insert_error = "INSERT INTO errores_usuario (usuario_id, pregunta_id, respuesta_usuario, respuesta_correcta, intento) VALUES (?, ?, ?, ?, ?)";
            $stmt_error = $conexion->prepare($insert_error);
            $stmt_error->bind_param("iissi", $usuario_id, $pregunta_id, $respuesta_usuario, $respuesta_correcta, $intento_actual);
            $stmt_error->execute();
        }
        $respuestas_procesadas++;
    }

    // Registrar el intento aunque no haya respuestas
    if ($respuestas_procesadas === 0) {
        $fecha_respuesta = date("Y-m-d H:i:s");
        $insert_vacio = "INSERT INTO respuestas_usuario (usuario_id, pregunta_id, respuesta, es_correcta, fecha_respuesta, intento, tema_id) VALUES (?, NULL, NULL, 0, ?, ?, ?)";
        $stmt_vacio = $conexion->prepare($insert_vacio);
        $stmt_vacio->bind_param("issi", $usuario_id, $fecha_respuesta, $intento_actual, $tema_id);
        $stmt_vacio->execute();
    }

    header("Location: ../../php/resultados_usuario/resultado.php?usuario_id=" . urlencode($usuario_id));
    exit();
} else {
    die("No se recibieron respuestas válidas.");
}
