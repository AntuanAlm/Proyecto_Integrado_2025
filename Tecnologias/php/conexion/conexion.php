<?php
$host = "localhost:3310";       
$usuario = "root";         
$contrasena = "";          
$base_datos = "autoescuela";

$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer codificación
$conexion->set_charset("utf8");

?>


