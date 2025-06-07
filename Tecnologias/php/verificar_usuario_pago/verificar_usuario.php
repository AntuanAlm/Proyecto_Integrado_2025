<?php
// Inicia la sesión para acceder a las variables de sesión del usuario
session_start();

// Establece el tipo de contenido de la respuesta como JSON
header("Content-Type: application/json");

// Incluye el archivo de conexión a la base de datos
require_once("../../php/conexion/conexion.php");

// Inicializa la respuesta indicando si la sesión está activa y los productos comprados
$response = [
    "sesion_activa" => isset($_SESSION['usuario']),
    "puede_acceder_test" => false,
    "productos_comprados" => [] // Guarda todos los productos comprados sin duplicados
];

// Si no hay sesión activa, devuelve la respuesta y termina la ejecución
if (!isset($_SESSION["usuario"])) {
    echo json_encode($response);
    exit();
}

// Obtiene el ID del usuario desde la sesión
$usuario_id = $_SESSION["usuario"]["id"];

// Consulta los productos comprados sin duplicados
$query = "SELECT DISTINCT producto FROM compras WHERE usuario_id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

// Guarda los productos comprados en el array, eliminando duplicados
while ($row = $result->fetch_assoc()) {
    $response["productos_comprados"][] = $row["producto"];
}

// Si el usuario ha comprado "Teórico" o "Pack Completo", puede acceder al test
$response["puede_acceder_test"] = in_array("Teórico", $response["productos_comprados"]) || in_array("Pack Completo", $response["productos_comprados"]);

// Cierra la consulta y la conexión a la base de datos
$stmt->close();
$conexion->close();

// Devuelve la respuesta en formato JSON
echo json_encode($response);
?>
