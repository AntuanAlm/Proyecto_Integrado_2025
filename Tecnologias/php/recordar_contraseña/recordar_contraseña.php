<?php
session_start();
include 'C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/php/conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consulta preparada para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT id, contrasena, tipo_usuario FROM profesores WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hash, $tipo_usuario);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($contrasena, $hash)) {
            $_SESSION['usuario_id'] = $id;
            
            // Redirigir según el tipo de usuario
            if ($tipo_usuario === 'profesora') {
                header("Location: C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/html/area_profesora/area_profesora.php");
            } else {
                header("Location: C:/xampp/htdocs/Proyecto_Integrado_2025/Tecnologias/html/area_profesor/area_profesor.php");
            }
            
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no registrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
