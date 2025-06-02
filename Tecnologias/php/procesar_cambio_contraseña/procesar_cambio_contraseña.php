<?php
header("Content-Type: text/html; charset=UTF-8");
require_once('../../php/conexion/conexion.php');

$correo = $_POST['correo'] ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? '';
$nueva_contrasena = $_POST['nueva_contrasena'] ?? '';

if (empty($correo) || empty($tipo_usuario) || empty($nueva_contrasena)) {
    echo "<p style='color: red;'>⚠️ Datos inválidos.</p>";
    exit();
}

// Hashear la nueva contraseña
$hash_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
$tabla = $tipo_usuario === 'profesor' ? 'profesores' : 'clientes';

$stmt = $conexion->prepare("UPDATE $tabla SET contrasena = ? WHERE correo = ?");
$stmt->bind_param("ss", $hash_contrasena, $correo);
$stmt->execute();

// Redirigir según el tipo de usuario
$url_redireccion = $tipo_usuario === "profesor" ? "../../html/login_area_profesores/login_area_profesores.php" : "../../html/login_usuario/login_usuario.html";

// Mostrar mensaje de éxito antes de la redirección
echo "<p style='color: green; font-size: 18px;'>✅ ¡Tu contraseña ha sido actualizada correctamente! En breves serás redirigido al login.</p>";
echo "<script>setTimeout(function(){ window.location.href = '$url_redireccion'; }, 3000);</script>";
?>
