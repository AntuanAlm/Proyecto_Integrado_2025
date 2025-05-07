<?php
include("../conexion/conexion.php"); // Incluir conexión

// Recuperar respuestas enviadas
$respuestas_usuario = $_POST['respuesta']; 

// Consulta para obtener las respuestas correctas desde la base de datos
$sql = "SELECT * FROM preguntas_test_tematicos WHERE test_id = 1 ORDER BY numero_pregunta ASC";
$resultado = $conexion->query($sql);

// Variable para contar aciertos
$aciertos = 0;

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        // Verificar si la respuesta del usuario es correcta
        $numero_pregunta = $fila["numero_pregunta"];
        $respuesta_correcta = $fila["respuesta_correcta"]; // Asumiendo que tienes una columna de respuesta correcta
        
        // Verificar si la respuesta del usuario es correcta
        if ($respuestas_usuario[$numero_pregunta] == $respuesta_correcta) {
            $aciertos++;
        }
    }
}

// Mostrar resultado
$total_preguntas = $resultado->num_rows;
echo "<h1>Resultado del Test 1</h1>";
echo "<p>Has acertado " . $aciertos . " de " . $total_preguntas . " preguntas.</p>";
?>
