<?php
session_start();
include("C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php");

// Si el profesor ya tiene sesión activa, evitar que vuelva a iniciar sesión
if (isset($_SESSION["profesor_id"])) {
    if ($_SESSION["profesor_nombre"] === "Juan") {
        header("Location: ../../html/area_profesor/area_profesor.php");
    } elseif ($_SESSION["profesor_nombre"] === "María") {
        header("Location: ../../html/area_profesora/area_profesora.php");
    }
    exit();
}

// Bloquear el acceso al login de profesores si ya hay una sesión activa como alumno
if (isset($_SESSION["usuario"]["id"])) {
    header("Location: ../../html/area_alumnos/area_alumnos.php?error=Ya_tienes_sesion");
    exit();
}

// Verificar que se recibió una solicitud POST antes de procesar el login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Obtener los datos del profesor
    $stmt = $conexion->prepare("SELECT id, nombre, tipo_clase, contrasena FROM profesores WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $profesor = $resultado->fetch_assoc();

        // Verificar la contraseña encriptada
        if (password_verify($contrasena, $profesor["contrasena"])) {
            // Establecer sesión correctamente
            $_SESSION["profesor_id"] = $profesor["id"];
            $_SESSION["profesor_nombre"] = $profesor["nombre"];
            $_SESSION["tipo_clase"] = $profesor["tipo_clase"];

            // Asegurar que la sesión dura más tiempo
            setcookie(session_name(), session_id(), time() + 86400, "/");

            // Redirigir automáticamente según el profesor
            if ($_SESSION["profesor_nombre"] === "Juan") {
                header("Location: ../../html/area_profesor/area_profesor.php");
            } elseif ($_SESSION["profesor_nombre"] === "María") {
                header("Location: ../../html/area_profesora/area_profesora.php");
            } else {
                echo "Error: Profesor no identificado.";
            }
            exit();
        } else {
            echo "Error: Contraseña incorrecta.";
        }
    } else {
        echo "Error: Correo no registrado.";
    }
} else {
    echo "Error: Método de solicitud no válido.";
}
?>
