<?php
session_start();
header("Content-Type: application/json");
require_once("../../php/conexion/conexion.php");

$response = ["success" => false];

if (!isset($_SESSION["usuario"])) {
    $response["error"] = "No hay sesión activa.";
    echo json_encode($response);
    exit();
}

// Obtener datos del carrito enviados por `registrar_compra.js`
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["carrito"]) && count($data["carrito"]) > 0) {
    $usuario_id = $_SESSION["usuario"]["id"];
    $conexion->begin_transaction();

    foreach ($data["carrito"] as $item) {
        $producto = $item["nombre"];
        $precio = $item["precio"];

        $query = "INSERT INTO compras (usuario_id, producto, precio, fecha_compra) VALUES (?, ?, ?, NOW())";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("iss", $usuario_id, $producto, $precio);
        $stmt->execute();
    }

    $conexion->commit();
    $stmt->close();
    $conexion->close();

    $response["success"] = true;
} else {
    $response["error"] = "No se enviaron datos de compra.";
}

echo json_encode($response);
?>
