<?php
$host = "localhost:3310";       // importante lo del 3310.
$usuario = "root";         // cambia si usas otro usuario
$contrasena = "";          // cambia si tienes contraseña en tu MySQL
$base_datos = "autoescuela";

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer codificación
$conexion->set_charset("utf8");

// Puedes dejar esto si quieres comprobar que todo va bien (luego lo puedes comentar)
#echo "Conexión exitosa";
?>


