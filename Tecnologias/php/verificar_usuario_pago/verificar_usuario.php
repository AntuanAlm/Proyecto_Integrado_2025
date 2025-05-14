<?php
session_start();
header("Content-Type: application/json");

// 🔎 Verificar si el usuario tiene sesión iniciada
$response = ["sesion_activa" => isset($_SESSION['usuario'])];

echo json_encode($response);
?>
