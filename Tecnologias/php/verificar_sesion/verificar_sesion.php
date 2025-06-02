<?php
session_start(); // Inicia la sesión

// Verificar si la sesión está activa
if (isset($_SESSION['usuario_id'])) {
    // Si la sesión está activa, redirigir a la pasarela de pago
    header("Location: /Proyecto_Integrado_2025/Tecnologias/pasarela_pago.html"); // Ruta correcta
    exit();
} else {
    // Si no está logueado, redirigir a login o registro
    header("Location: /Proyecto_Integrado_2025/Tecnologias/html/login_usuario/login_usuario.html"); // Ruta correcta
    exit();
}
?>
<!-- Este php está hecho por la redirección del pago -->
