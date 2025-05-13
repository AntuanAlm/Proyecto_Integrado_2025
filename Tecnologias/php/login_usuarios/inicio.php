<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    // Si no hay sesión activa, redirigir al login
    header("Location: ../html/login_usuario/login_usuario.html"); // Asegúrate de que la ruta sea correcta
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Área Cliente</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
    <p><a href="../php/login_usuarios/logout.php">Cerrar sesión</a></p>
</body>
</html>
