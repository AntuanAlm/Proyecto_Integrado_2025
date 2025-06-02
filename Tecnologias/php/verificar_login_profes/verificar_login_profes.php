<?php
header("Content-Type: application/json");
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$datos = json_decode(file_get_contents("php://input"), true);
if (!$datos) {
    echo json_encode(["error" => "No se han recibido datos correctamente."]);
    exit();
}

$correo = $datos["correo"] ?? "";
$contrasena = $datos["contrasena"] ?? "";

// Consultar la base de datos
$stmt = $conexion->prepare("SELECT contrasena FROM profesores WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $profesor = $resultado->fetch_assoc();

    if (password_verify($contrasena, $profesor["contrasena"])) {
        echo json_encode(["validacion" => "correcta"]);
    } else {
        echo json_encode(["error" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["error" => "Correo no registrado."]);
}

exit();
?>
<!-- Este verificar es para verificar que tengo la conexion con la base de datos para que las contraseñas y los correos sean correctos -->