<?php
session_start();
require_once '../conexion/conexion.php'; // Asegúrate de que la ruta es correcta

// Recoger datos del formulario
$correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

$errores = [];

if (empty($correo) || empty($contrasena)) {
    $errores[] = "Todos los campos son obligatorios.";
} else {
    // Buscar al usuario por correo
    $query = "SELECT * FROM clientes WHERE correo = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Contraseña válida → iniciar sesión
            $_SESSION['cliente_id'] = $usuario['id'];
            $_SESSION['cliente_nombre'] = $usuario['nombre'];
            $_SESSION['cliente_correo'] = $usuario['correo'];

            // Redirigir a la zona privada
            header("Location: /Proyecto_Integrado_2025/zona_privada/inicio.php");
            exit();
        } else {
            $errores[] = "Correo o contraseña incorrectos.";
        }
    } else {
        $errores[] = "Correo o contraseña incorrectos.";
    }

    $stmt->close();
}

$conexion->close();

// Mostrar errores si los hay
if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}
?>
