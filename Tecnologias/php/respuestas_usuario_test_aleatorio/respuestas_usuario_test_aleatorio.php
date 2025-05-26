<?php
session_start();

include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Validar autenticación
if (!isset($_SESSION["usuario"]["id"])) {
    die("Error: Usuario no autenticado.");
}

$usuario_id = intval($_SESSION["usuario"]["id"]);

// Obtener número de intento actual
$consulta_intento = "SELECT IFNULL(MAX(intento), 0) + 1 AS nuevo_intento FROM respuestas_usuario WHERE usuario_id = ?";
$stmt_intento = $conexion->prepare($consulta_intento);
$stmt_intento->bind_param("i", $usuario_id);
$stmt_intento->execute();
$resultado_intento = $stmt_intento->get_result();
$intento_actual = intval($resultado_intento->fetch_assoc()["nuevo_intento"]);
$stmt_intento->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $respuestas_procesadas = 0;

    foreach ($_POST["respuesta"] ?? [] as $pregunta_id => $respuesta_usuario) {
        $pregunta_id = intval($pregunta_id);
        $respuesta_usuario = trim($respuesta_usuario);

        if ($pregunta_id <= 0 || $respuesta_usuario === "") {
            // Pregunta inválida o respuesta vacía, saltar
            continue;
        }

        // Obtener la respuesta correcta y el tema_id desde preguntas_test_aleatorios
        $consulta = "SELECT respuesta_correcta, tema_id FROM preguntas_test_aleatorios WHERE id = ?";
        $stmt = $conexion->prepare($consulta);
        if (!$stmt) {
            error_log("Error prepare consulta preguntas_test_aleatorios: " . $conexion->error);
            continue;
        }
        $stmt->bind_param("i", $pregunta_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();
        $stmt->close();

        if (!$fila) {
            // Pregunta no encontrada, saltar
            continue;
        }

        $respuesta_correcta = $fila["respuesta_correcta"];
        $tema_id = intval($fila["tema_id"]);
        $es_correcta = ($respuesta_usuario === $respuesta_correcta) ? 1 : 0;
        $fecha_respuesta = date("Y-m-d H:i:s");

        // Insertar respuesta del usuario
        $insert = "INSERT INTO respuestas_usuario (usuario_id, pregunta_id, respuesta, es_correcta, fecha_respuesta, intento, tema_id)
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conexion->prepare($insert);
        if (!$stmt_insert) {
            error_log("Error prepare insert respuestas_usuario: " . $conexion->error);
            continue;
        }

        $stmt_insert->bind_param("iisiiii", $usuario_id, $pregunta_id, $respuesta_usuario, $es_correcta, $fecha_respuesta, $intento_actual, $tema_id);

        if (!$stmt_insert->execute()) {
            error_log("Error en insert respuestas_usuario: " . $stmt_insert->error);
        }
        $stmt_insert->close();

        if (!$es_correcta) {
            error_log("Respuesta incorrecta para pregunta_id $pregunta_id: usuario='$respuesta_usuario', correcta='$respuesta_correcta'");

            $insert_error = "INSERT INTO errores_usuario (usuario_id, pregunta_id, respuesta_usuario, respuesta_correcta, intento)
                             VALUES (?, ?, ?, ?, ?)";
            $stmt_error = $conexion->prepare($insert_error);
            if (!$stmt_error) {
                error_log("Error prepare errores_usuario: " . $conexion->error);
                continue;
            }

            $stmt_error->bind_param("iissi", $usuario_id, $pregunta_id, $respuesta_usuario, $respuesta_correcta, $intento_actual);

            if (!$stmt_error->execute()) {
                error_log("Error execute errores_usuario: " . $stmt_error->error);
            } else {
                error_log("Error registrado correctamente para pregunta_id $pregunta_id");
            }
            $stmt_error->close();
        }

        $respuestas_procesadas++;
    }

    // Registrar intento vacío si no se respondió nada
    if ($respuestas_procesadas === 0) {
        $fecha_respuesta = date("Y-m-d H:i:s");
        $tema_id = 101; // Identificador del test aleatorio

        // Ajusto para que pregunta_id y respuesta sean NULL usando NULL explícito en SQL
        $insert_vacio = "INSERT INTO respuestas_usuario (usuario_id, pregunta_id, respuesta, es_correcta, fecha_respuesta, intento, tema_id)
                         VALUES (?, NULL, NULL, 0, ?, ?, ?)";
        $stmt_vacio = $conexion->prepare($insert_vacio);
        if (!$stmt_vacio) {
            error_log("Error prepare insert intento vacío: " . $conexion->error);
        } else {
            $stmt_vacio->bind_param("isii", $usuario_id, $fecha_respuesta, $intento_actual, $tema_id);
            if (!$stmt_vacio->execute()) {
                error_log("Error execute insert intento vacío: " . $stmt_vacio->error);
            }
            $stmt_vacio->close();
        }
    }

    // Redirigir al resultado
    header("Location: ../../php/resultados_usuario/resultado.php?usuario_id=" . urlencode($usuario_id));
    exit();
} else {
    die("No se recibieron respuestas válidas.");
}
