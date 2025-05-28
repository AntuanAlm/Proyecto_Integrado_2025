<?php
session_start();
include("../../php/conexion/conexion.php");

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

        // Verificar la contraseña encriptada con `bcrypt`
        if (password_verify($contrasena, $profesor["contrasena"])) {
            $_SESSION["profesor_id"] = $profesor["id"];
            $_SESSION["profesor_nombre"] = $profesor["nombre"];
            $_SESSION["tipo_clase"] = $profesor["tipo_clase"];

            // Redirigir según el profesor
            if ($profesor["nombre"] === "Juan") {
                header("Location: ../../html/area_profesor/area_profesor.php");
            } elseif ($profesor["nombre"] === "María") {
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
}
?>
