<?php
header("Content-Type: application/json");
require_once('../../php/conexion/conexion.php');

$datos = json_decode(file_get_contents("php://input"), true);
$correo = trim($datos["correo"] ?? "");

if (empty($correo)) {
    echo json_encode(["error" => "El correo no puede estar vacío."]);
    exit();
}

// Buscar en la base de datos si el correo pertenece a un profesor o alumno
$stmt = $conexion->prepare("SELECT 'profesor' AS tipo_usuario FROM profesores WHERE correo = ? 
                            UNION 
                            SELECT 'alumno' AS tipo_usuario FROM clientes WHERE correo = ?");
$stmt->bind_param("ss", $correo, $correo);
$stmt->execute();
$resultado = $stmt->get_result();
$tipo_usuario = $resultado->fetch_assoc()['tipo_usuario'] ?? null;

if (!$tipo_usuario) {
    echo json_encode(["error" => "Correo no registrado."]);
} else {
    echo json_encode(["tipo_usuario" => $tipo_usuario]);
}
exit();
?>
