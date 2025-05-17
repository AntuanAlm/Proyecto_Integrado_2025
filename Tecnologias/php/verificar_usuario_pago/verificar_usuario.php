<?php
// Inicia la sesión para acceder a las variables de sesión del usuario
session_start();

// Establece el tipo de contenido de la respuesta como JSON
header("Content-Type: application/json");

// Incluye el archivo de conexión a la base de datos
require_once("../../php/conexion/conexion.php");

// Inicializa la respuesta indicando si la sesión está activa y si puede acceder al test
$response = [
    "sesion_activa" => isset($_SESSION['usuario']),
    "puede_acceder_test" => false
];

// Si no hay sesión activa, devuelve la respuesta y termina la ejecución
if (!isset($_SESSION["usuario"])) {
    echo json_encode($response);
    exit();
}

// Obtiene el ID del usuario desde la sesión
$usuario_id = $_SESSION["usuario"]["id"];

// Consulta si el usuario ha comprado los tests (Teórico o Pack Completo)
$query = "SELECT COUNT(*) AS total FROM compras WHERE usuario_id = ? AND (producto = 'Teórico' OR producto = 'Pack Completo')";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Si el usuario ha realizado alguna compra válida, permite el acceso al test
if ($row["total"] > 0) {
    $response["puede_acceder_test"] = true;
}

// Cierra la consulta y la conexión a la base de datos
$stmt->close();
$conexion->close();

// Devuelve la respuesta en formato JSON
echo json_encode($response);
?>
