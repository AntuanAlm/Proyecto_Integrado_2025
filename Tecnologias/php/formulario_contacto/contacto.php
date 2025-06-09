<?php
require_once '../conexion/conexion.php';

// Mostrar errores para depuración (eliminar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validar datos de entrada y evitar caracteres peligrosos
function limpiarDato($dato, $conexion) {
    return mysqli_real_escape_string($conexion, trim($dato));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar cada campo antes de procesarlo
    $nombre = isset($_POST['nombre']) ? limpiarDato($_POST['nombre'], $conexion) : null;
    $apellidos = isset($_POST['apellidos']) ? limpiarDato($_POST['apellidos'], $conexion) : null;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : null;
    $telefono = isset($_POST['telefono']) ? limpiarDato($_POST['telefono'], $conexion) : null;
    $asunto = isset($_POST['asunto']) ? limpiarDato($_POST['asunto'], $conexion) : null;
    $mensaje = isset($_POST['mensaje']) ? limpiarDato($_POST['mensaje'], $conexion) : null;

    // Verificar que los campos requeridos no estén vacíos
    if (!$nombre || !$apellidos || !$email || !$telefono || !$asunto || !$mensaje) {
        die("⚠️ Todos los campos son obligatorios.");
    }

    // Validar que el email tenga un formato correcto
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("⚠️ El email ingresado no es válido.");
    }

    // Validar que el teléfono tenga exactamente 9 números
    if (!preg_match('/^[0-9]{9}$/', $telefono)) {
        die("⚠️ El teléfono debe contener exactamente 9 números.");
    }

    // Validar que el mensaje tenga al menos 10 caracteres
    if (strlen($mensaje) < 10) {
        die("⚠️ El mensaje debe contener al menos 10 caracteres.");
    }

    // Usar sentencias preparadas para evitar inyección SQL
    $stmt = $conexion->prepare("INSERT INTO contactos (nombre, apellidos, email, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellidos, $email, $telefono, $asunto, $mensaje);

    if ($stmt->execute()) {
        // Redirige a la página de confirmación HTML
        header("Location: /Proyecto_Integrado_2025/Tecnologias/html/confirmacion_form_contacto_enviado/confirmacion_form_enviado.html");
        exit(); // ¡Muy importante! Detiene el script tras redirigir
    } else {
        echo "<div style='background-color:#f8d7da; color:#721c24; padding:10px; border-radius:5px;'>❌ Error al enviar el formulario.</div>";
    }

    $stmt->close();
    $conexion->close();
} else {
    die("Acceso no permitido.");
}
?>
