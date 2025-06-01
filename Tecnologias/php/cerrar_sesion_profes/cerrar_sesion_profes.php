<?php
session_start();

// Eliminar todas las variables de sesión correctamente
session_unset();
$_SESSION = [];  

// Borrar la cookie de sesión
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/', '', false, true);
}

// Destruir la sesión
session_destroy();

// Regenerar el ID de sesión para mayor seguridad
session_start();
session_regenerate_id(true);

// Redirigir a `index.php` con la ruta correcta
header("Location: http://localhost/Proyecto_Integrado_2025/Tecnologias/html/Vista_Principal/index.php?cerrado=1");
exit();
