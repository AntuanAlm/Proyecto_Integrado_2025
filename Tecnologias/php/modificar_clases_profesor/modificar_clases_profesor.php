<?php
session_start(); // Inicia la sesión PHP
header("Content-Type: application/json"); // Establece el tipo de contenido como JSON
require_once("../../php/conexion/conexion.php"); // Incluye el archivo de conexión a la base de datos

$response = ["success" => false]; // Inicializa la respuesta como fallo por defecto

// Recibir los datos enviados desde `area_profesor.php`
$data = json_decode(file_get_contents("php://input"), true); // Decodifica los datos JSON recibidos

if (isset($data["id"]) && isset($data["cambio"])) { // Verifica si existen los datos necesarios
    $alumno_id = intval($data["id"]); // Convierte el id del alumno a entero
    $cambio = intval($data["cambio"]); // Convierte el cambio a entero

    // Asegurar que `clases_practicas` nunca sea negativo
    $query = "UPDATE clientes SET clases_practicas = CASE 
                WHEN clases_practicas + ? < 0 THEN 0 
                ELSE clases_practicas + ? 
              END WHERE id = ?"; // Consulta SQL para actualizar clases_practicas sin permitir valores negativos

    $stmt = $conexion->prepare($query); // Prepara la consulta SQL
    $stmt->bind_param("iii", $cambio, $cambio, $alumno_id); // Asocia los parámetros a la consulta

    if ($stmt->execute()) { // Ejecuta la consulta
        $response["success"] = true; // Si tiene éxito, marca la respuesta como exitosa
    } else {
        $response["error"] = "Error al actualizar la base de datos."; // Si falla, agrega un mensaje de error
    }

    $stmt->close(); // Cierra la consulta preparada
    $conexion->close(); // Cierra la conexión a la base de datos
} else {
    $response["error"] = "Datos incorrectos."; // Si faltan datos, agrega un mensaje de error
}

echo json_encode($response); // Devuelve la respuesta en formato JSON
?>
