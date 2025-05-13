<?php
session_start();  // Inicia la sesión si no está iniciada

// Eliminar todas las variables de sesión
$_SESSION = array();

// Si se desea eliminar la cookie de sesión, también:
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

echo "<h1>Sesión destruida</h1>";
?>
