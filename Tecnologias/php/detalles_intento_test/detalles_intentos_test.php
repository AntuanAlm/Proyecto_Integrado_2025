<?php
session_start();
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

if (!isset($_GET["usuario_id"]) || !isset($_GET["intento"])) {
    die("Error: Falta información del intento.");
}

$usuario_id = intval($_GET["usuario_id"]);
$intento = intval($_GET["intento"]);

$consulta = "SELECT DISTINCT p.id AS pregunta_id, p.pregunta, r.respuesta, r.es_correcta, t.tema_id, t.nombre_tema
             FROM preguntas_test_tematicos p
             LEFT JOIN respuestas_usuario r ON p.id = r.pregunta_id AND r.usuario_id = ? AND r.intento = ?
             LEFT JOIN temas t ON p.tema_id = t.tema_id
             WHERE r.usuario_id = ? AND r.intento = ?
             ORDER BY p.id ASC";


$stmt = $conexion->prepare($consulta);
$stmt->bind_param("iiii", $usuario_id, $intento, $usuario_id, $intento);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    die("No hay respuestas registradas en este intento.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Intento <?= $intento ?></title>
    <link rel="stylesheet" href="../../css/detalles_intentos_test/detalles_intentos_test.css">
</head>
<body>

<h1>Detalle del Intento <?= $intento ?></h1>
<table border="1">
    <tr>
        <th>Número de Pregunta</th>
        <th>Pregunta</th>
        <th>Tu respuesta</th>
        <th>Estado</th>
    </tr>

    <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
    <td><?= htmlspecialchars($fila["pregunta_id"]) ?></td> <!-- Ahora se muestra el número correcto de la pregunta -->
    <td><?= htmlspecialchars($fila["pregunta"]) ?></td>
    <td><?= $fila["respuesta"] ? htmlspecialchars($fila["respuesta"]) : 'No contestada' ?></td>
    <td>
        <?php if (is_null($fila["respuesta"])): ?>
            🟡 No contestada
        <?php elseif ($fila["es_correcta"] == 1): ?>
            ✅ Correcta
        <?php else: ?>
            ❌ Incorrecta
        <?php endif; ?>
    </td>
</tr>

    <?php endwhile; ?>
</table>

<a href="../../php/resultados_usuario/resultado.php?usuario_id=<?= $usuario_id ?>">← Volver a Resultados</a>

</body>
</html>
