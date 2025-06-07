<?php
session_start();
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Validar que `usuario_id` ha sido pasado por URL
if (!isset($_GET["usuario_id"]) && !isset($_GET["alumno_id"])) {
    die("Error: Usuario no especificado.");
}

$usuario_id = isset($_GET["usuario_id"]) ? intval($_GET["usuario_id"]) : intval($_GET["alumno_id"]);

// Verificar conexión con la base de datos
if (!$conexion) {
    die("Error de conexión con la base de datos.");
}

// **Verificar si el usuario tiene test realizados**
$consulta_test = "SELECT COUNT(*) AS total_tests FROM respuestas_usuario WHERE usuario_id = ?";
$stmt_test = $conexion->prepare($consulta_test);
$stmt_test->bind_param("i", $usuario_id);
$stmt_test->execute();
$resultado_test = $stmt_test->get_result();
$fila_test = $resultado_test->fetch_assoc();
$sin_tests = ($fila_test["total_tests"] == 0);

// **Consulta original sin modificar**
$consulta_general = "
SELECT r.intento,
       r.tema_id,
       CASE 
           WHEN r.tema_id BETWEEN 201 AND 205 THEN 'Test de Examen'
           WHEN r.tema_id BETWEEN 101 AND 107 THEN 'Test Aleatorio'
           ELSE COALESCE(t_p.nombre_tema, t_r.nombre_tema, 'Sin título')
       END AS nombre_tema,
       COUNT(r.pregunta_id) AS total_preguntas,
       SUM(CASE WHEN r.es_correcta = 1 THEN 1 ELSE 0 END) AS total_aciertos,
       SUM(CASE WHEN r.es_correcta = 0 AND r.pregunta_id IS NOT NULL THEN 1 ELSE 0 END) AS total_errores
FROM respuestas_usuario r
LEFT JOIN preguntas_test_tematicos p ON r.pregunta_id = p.id
LEFT JOIN temas t_p ON p.tema_id = t_p.tema_id
LEFT JOIN temas t_r ON r.tema_id = t_r.tema_id
WHERE r.usuario_id = ?
GROUP BY r.intento, r.tema_id
ORDER BY r.intento ASC
";

$stmt_general = $conexion->prepare($consulta_general);
$stmt_general->bind_param("i", $usuario_id);
$stmt_general->execute();
$resultado_general = $stmt_general->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del Test</title>
    <link rel="stylesheet" href="../../css/test_resultados/resultados.css">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png">

    <!-- <script>
document.addEventListener("DOMContentLoaded", function () {
    <?php if ($sin_tests): ?>
        alert("⚠️ Aún no ha realizado ningún test.");
    <?php endif; ?>
});
</script> -->

</head>
<body>

<h1>Resultados del Test</h1>

<?php if ($sin_tests): ?>
    <p style="text-align:center; font-size:1.2rem; color:#ff4d4d;">
        ⚠️ Aún no ha realizado ningún test.
    </p>
<?php else: ?>
<table>
    <tr>
        <th>Intento</th>
        <th>Número del Tema</th>
        <th>Nombre del Tema</th>
        <th>Preguntas contestadas</th>
        <th>Aciertos</th>
        <th>Errores</th>
        <th>Porcentaje de aciertos</th>
        <th>Estado</th>
    </tr>

    <?php while ($fila = $resultado_general->fetch_assoc()): ?>
        <?php 
        $porcentaje = ($fila["total_preguntas"] > 0) 
                      ? ($fila["total_aciertos"] / $fila["total_preguntas"]) * 100 
                      : 0;

        // Lógica de aprobado: mínimo 27 preguntas y 27 aciertos
        $estado = "Suspenso";
        $clase_estado = "estado-suspenso";
        if ($fila["total_preguntas"] >= 27 && $fila["total_aciertos"] >= 27) {
            $estado = "Aprobado";
            $clase_estado = "estado-aprobado";
        }
        ?>
        <tr>
            <td>
                <a href="#" title="Ver tus respuestas" onclick="validarIntento(event, <?= $fila['total_preguntas'] ?>, <?= $fila['intento'] ?>, <?= $usuario_id ?>)">
                    <?= htmlspecialchars($fila["intento"]) ?>
                </a>
            </td>
            <td><?= htmlspecialchars($fila["tema_id"]) ?></td>
            <td><?= htmlspecialchars($fila["nombre_tema"]) ?></td>
            <td><?= $fila["total_preguntas"] ?></td>
            <td><?= $fila["total_aciertos"] ?></td>
            <td><?= $fila["total_errores"] ?></td>
            <td><?= round($porcentaje, 2) ?>%</td>
            <td class="<?= $clase_estado ?>"><?= $estado ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<?php endif; ?>

<div class="volver">
    <?php
    if (isset($_SESSION["profesor_id"])) {
        // Si el profesor es Juan (ID = 1), redirigir a `area_profesor.php`
        if ($_SESSION["profesor_id"] == 1) {
            echo '<a href="../../html/area_profesor/area_profesor.php">← Volver al perfil</a>';
        }
        // Si el profesor es María (ID = 2), redirigir a `area_profesora.php`
        elseif ($_SESSION["profesor_id"] == 2) {
            echo '<a href="../../html/area_profesora/area_profesora.php">← Volver al perfil</a>';
        }
    } 
    // Si el usuario es alumno, redirigir a área alumnos
    elseif (isset($_SESSION["usuario"]["id"])) {
        echo '<a href="../../html/area_alumnos/area_alumnos.php">← Volver al perfil</a>';
    } 
    // Si no hay sesión activa, redirigir al login
    else {
        echo '<a href="../../html/login_usuario/login_usuario.html">← Volver al inicio</a>';
    }
    ?>
</div>



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

<script>
    // Evita volver al test con el botón atrás
    window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, null, window.location.href);
        alert("🚫 No puedes volver al test una vez terminado.");
    };
</script>


</body>
</html>
