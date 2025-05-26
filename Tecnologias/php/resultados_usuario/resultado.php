<?php
session_start();

// Validar sesión del usuario
if (!isset($_SESSION["usuario"]["id"])) {
    die("Error: Usuario no autenticado.");
}

include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Validar la conexión
if (!$conexion) {
    die("Error de conexión con la base de datos.");
}

// Obtener usuario desde GET
if (!isset($_GET["usuario_id"]) || empty($_GET["usuario_id"])) {
    die("Error: Usuario no especificado.");
}
$usuario_id = intval($_GET["usuario_id"]);

// Consulta para obtener los resultados generales del test
$consulta_general = "SELECT r.intento, 
       CASE 
           WHEN r.tema_id = 101 THEN 'Test Aleatorio 1'
           ELSE t.tema_id
       END AS tema_id,
       CASE 
           WHEN r.tema_id = 101 THEN 'Test Aleatorio 1'
           ELSE t.nombre_tema
       END AS nombre_tema,
       COUNT(r.pregunta_id) AS total_preguntas, 
       SUM(CASE WHEN r.es_correcta = 1 THEN 1 ELSE 0 END) AS total_aciertos, 
       SUM(CASE WHEN r.es_correcta = 0 THEN 1 ELSE 0 END) AS total_errores
FROM respuestas_usuario r
LEFT JOIN preguntas_test_tematicos p ON r.pregunta_id = p.id
LEFT JOIN temas t ON p.tema_id = t.tema_id
WHERE r.usuario_id = ?
GROUP BY r.intento, r.tema_id, t.tema_id, t.nombre_tema
ORDER BY r.intento ASC";

$stmt_general = $conexion->prepare($consulta_general);
$stmt_general->bind_param("i", $usuario_id);
$stmt_general->execute();
$resultado_general = $stmt_general->get_result();

// Verificar si hay resultados
if ($resultado_general->num_rows === 0) {
    echo "<p>No hay registros para este usuario.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del Test</title>
    <link rel="stylesheet" href="../../css/test_resultados/resultados.css">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png">
</head>
<body>

<h1>Resultados del Test</h1>
<table border="1">
    <tr>
        <th>Intento</th>
        <th>Número del Tema</th>
        <th>Nombre del Tema</th>
        <th>Preguntas contestadas</th>
        <th>Aciertos</th>
        <th>Errores</th>
        <th>Porcentaje de aciertos</th>
    </tr>

    <?php while ($fila = $resultado_general->fetch_assoc()): ?>
        <?php 
        $porcentaje = ($fila["total_preguntas"] > 0) 
                      ? ($fila["total_aciertos"] / $fila["total_preguntas"]) * 100 
                      : 0;
        ?>
        <tr>
            <td>
                <a href="#" onclick="validarIntento(event, <?= $fila['total_preguntas'] ?>, <?= $fila['intento'] ?>, <?= $usuario_id ?>)">
                <?= htmlspecialchars($fila["intento"]) ?>
                </a>
            </td>
            <script>
                function validarIntento(event, totalPreguntas, intento, usuarioId) {
                    if (totalPreguntas === 0) {
                        alert("Este intento está vacío. No puedes acceder a él.");
                        event.preventDefault();
                    } else {
                        window.location.href = `../../php/detalles_intento_test/detalles_intentos_test.php?intento=${intento}&usuario_id=${usuarioId}`;
                    }
                }
            </script>

            <td><?= htmlspecialchars($fila["tema_id"]) ?></td>
            <td><?= htmlspecialchars($fila["nombre_tema"] ?? "Sin título") ?></td>
            <td><?= $fila["total_preguntas"] ?></td>
            <td><?= $fila["total_aciertos"] ?></td>
            <td><?= $fila["total_errores"] ?></td>
            <td><?= round($porcentaje, 2) ?>%</td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="../../html/area_alumnos/area_alumnos.php">Volver al perfil</a>

</body>
</html>
