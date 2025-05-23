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

// Obtener el usuario desde GET para asegurar acceso correcto
if (!isset($_GET["usuario_id"]) || empty($_GET["usuario_id"])) {
    die("Error: Usuario no especificado.");
}
$usuario_id = intval($_GET["usuario_id"]);

// Consulta para obtener los resultados generales del test
$consulta_general = "SELECT r.intento, t.tema_id, t.nombre_tema, 
                            COUNT(DISTINCT r.pregunta_id) AS total_preguntas, 
                            SUM(r.es_correcta) AS correctas,
                            (SELECT COUNT(*) FROM errores_usuario e WHERE e.usuario_id = r.usuario_id AND e.intento = r.intento) AS errores_totales
                     FROM respuestas_usuario r
                     LEFT JOIN preguntas_test_tematicos p ON r.pregunta_id = p.id
                     LEFT JOIN temas t ON p.tema_id = t.tema_id
                     WHERE r.usuario_id = ?
                     GROUP BY r.intento, t.tema_id, t.nombre_tema
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
                      ? ($fila["correctas"] / $fila["total_preguntas"]) * 100 
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
                    event.preventDefault(); // Detiene la redirección
                    
                } else {
                    window.location.href = `../../php/detalles_intento_test/detalles_intentos_test.php?intento=${intento}&usuario_id=${usuarioId}`;
            }
                }
            </script>

            <td>
    <?php
    if (!empty($fila["tema_id"])) {
        echo htmlspecialchars($fila["tema_id"]);
    } else {
        // Obtener el `tema_id` correctamente desde el primer registro del usuario
        $consulta_tema = "SELECT DISTINCT tema_id, 
                                 (SELECT nombre_tema FROM temas WHERE temas.tema_id = respuestas_usuario.tema_id LIMIT 1) AS nombre_tema
                          FROM respuestas_usuario
                          WHERE usuario_id = ? AND tema_id IS NOT NULL
                          ORDER BY intento ASC
                          LIMIT 1";

        $stmt_tema = $conexion->prepare($consulta_tema);
        $stmt_tema->bind_param("i", $usuario_id);
        $stmt_tema->execute();
        $resultado_tema = $stmt_tema->get_result();
        $fila_tema = $resultado_tema->fetch_assoc();

        echo htmlspecialchars($fila_tema["tema_id"] ?? 'Error');
    }
    ?>
</td>
<td>
    <?php
    if (!empty($fila["nombre_tema"])) {
        echo htmlspecialchars($fila["nombre_tema"]);
    } else {
        echo htmlspecialchars($fila_tema["nombre_tema"] ?? 'Error');
    }
    ?>
</td>

            <td><?= $fila["total_preguntas"] ?></td>
            <td><?= $fila["correctas"] ?></td>
            <td><?= $fila["errores_totales"] ?></td>
            <td><?= round($porcentaje, 2) ?>%</td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="../../html/area_alumnos/area_alumnos.php">Volver al perfil</a>


</body>
</html>
