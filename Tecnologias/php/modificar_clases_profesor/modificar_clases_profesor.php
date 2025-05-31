<?php
session_start();
header("Content-Type: application/json");
require_once("../../php/conexion/conexion.php");

$response = ["success" => false];

// 🔹 Recibir los datos enviados desde `area_profesor.php`
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["id"]) && isset($data["cambio"])) {
    $alumno_id = intval($data["id"]);
    $cambio = intval($data["cambio"]);

    // 🔹 Asegurar que `clases_practicas` nunca sea negativo
    $query = "UPDATE clientes SET clases_practicas = CASE 
                WHEN clases_practicas + ? < 0 THEN 0 
                ELSE clases_practicas + ? 
              END WHERE id = ?";

    $stmt = $conexion->prepare($query);
    $stmt->bind_param("iii", $cambio, $cambio, $alumno_id);

    if ($stmt->execute()) {
        $response["success"] = true;
    } else {
        $response["error"] = "Error al actualizar la base de datos.";
    }

    $stmt->close();
    $conexion->close();
} else {
    $response["error"] = "Datos incorrectos.";
}

echo json_encode($response);
?>
