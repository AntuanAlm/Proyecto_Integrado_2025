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
        $cantidad = isset($item["cantidad"]) ? $item["cantidad"] : 1; // Capturamos la cantidad comprada

        // Insertar la compra en la tabla `compras`
        $query = "INSERT INTO compras (usuario_id, producto, precio, cantidad, fecha_compra) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("issi", $usuario_id, $producto, $precio, $cantidad);
        $stmt->execute();

        // Si compra "Oportunidad Extra", aumentamos intentos de examen
        if ($producto === "Oportunidad Extra de Examen") {
        // Consultar cuántas oportunidades tiene el usuario
        $query_check = "SELECT oportunidades_examen FROM clientes WHERE id = ?";
        $stmt_check = $conexion->prepare($query_check);
        $stmt_check->bind_param("i", $usuario_id);
        $stmt_check->execute();
        $stmt_check->bind_result($oportunidades_actuales);
        $stmt_check->fetch();
        $stmt_check->close();

        // Permitir compra solo si tiene 0 oportunidades
        if ($oportunidades_actuales == 0) {
        $query_update = "UPDATE clientes SET oportunidades_examen = oportunidades_examen + ? WHERE id = ?";
        $stmt_update = $conexion->prepare($query_update);
        $stmt_update->bind_param("ii", $cantidad, $usuario_id);
        $stmt_update->execute();
        } else {
        $response["error"] = "❌ No puedes comprar una Oportunidad Extra si aún tienes intentos disponibles.";
        }
    }
        // Si compra una "Clase Práctica Suelta", aumentamos `clases_practicas` según cantidad comprada
        elseif ($producto === "Práctico" || $producto === "Clase Práctica Suelta") {
            $query_update = "UPDATE clientes SET clases_practicas = clases_practicas + ? WHERE id = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("ii", $cantidad, $usuario_id);
            $stmt_update->execute();
        }
        // Si compra un paquete de clases prácticas, aumentamos `clases_practicas` según la cantidad comprada
        elseif ($producto === "Pack Completo") {
            $clases_a_sumar = 10 * $cantidad;
            $oportunidades_a_sumar = 0 * $cantidad;
            $query_update = "UPDATE clientes SET clases_practicas = clases_practicas + ?, oportunidades_examen = oportunidades_examen + ? WHERE id = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("iii", $clases_a_sumar, $oportunidades_a_sumar, $usuario_id);
            $stmt_update->execute();
        } elseif ($producto === "Pack de 10 Clases Prácticas") {
            $clases_a_sumar = 10 * $cantidad;
            $query_update = "UPDATE clientes SET clases_practicas = clases_practicas + ? WHERE id = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("ii", $clases_a_sumar, $usuario_id);
            $stmt_update->execute();
        } elseif ($producto === "Pack de 20 Clases Prácticas") {
            $clases_a_sumar = 20 * $cantidad;
            $query_update = "UPDATE clientes SET clases_practicas = clases_practicas + ? WHERE id = ?";
            $stmt_update = $conexion->prepare($query_update);
            $stmt_update->bind_param("ii", $clases_a_sumar, $usuario_id);
            $stmt_update->execute();
        }
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
