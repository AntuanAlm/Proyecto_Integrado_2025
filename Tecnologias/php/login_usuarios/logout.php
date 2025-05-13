<?php
session_start();

// Conexión a la base de datos
require_once('../../php/conexion/conexion.php');

// Verifica si existe un usuario logueado
if (isset($_SESSION['usuario'])) {
    $usuario = mysqli_real_escape_string($conexion, $_SESSION['usuario']);
    
    // Actualiza el estado de sesión en la base de datos
    $query = "UPDATE clientes SET sesion_activa = 0 WHERE correo = '$usuario'";
    mysqli_query($conexion, $query);
}

// Vaciar variables de sesión
$_SESSION = [];

// Eliminar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Destruir la sesión
session_destroy();

// Redirigir a index.php
header("Location: ../../html/Vista_Principal/index.php?cerrado=1");
exit;
?>

