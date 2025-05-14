<?php
// Iniciar la sesión
session_start();

// Conexión a la base de datos
require_once('../../php/conexion/conexion.php');

// Si ya hay una sesión activa, redirigimos
if (isset($_SESSION['usuario'])) {
    header("Location: ../../html/Vista_Principal/index.php");
    exit();
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $usuario = mysqli_real_escape_string($conexion, $usuario);
    $contrasena = mysqli_real_escape_string($conexion, $contrasena);

    $query = "SELECT * FROM clientes WHERE correo = '$usuario'";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conexion));
    }

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($contrasena, $row['contrasena'])) {
            // Comprobamos si ya tiene una sesión activa
            if ($row['sesion_activa'] == 1) {
                echo "Este usuario ya tiene una sesión activa. Por favor, cierra sesión antes de volver a iniciar.";
                exit();
            }

            // Guardamos los datos del usuario en la sesión
            $_SESSION['usuario'] = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'email' => $row['correo']
            ];
            $_SESSION['ultimo_acceso'] = time();

            // Actualizamos la base de datos para marcar sesión activa
            $update = "UPDATE clientes SET sesion_activa = 1 WHERE correo = '$usuario'";
            mysqli_query($conexion, $update);

            header("Location: ../../html/Vista_Principal/index.php");
            exit();
        } else {
            echo "Correo o contraseña incorrectos.";
        }
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>
