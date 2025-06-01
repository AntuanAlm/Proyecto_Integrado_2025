<?php
// 🔹 Iniciar la sesión de manera segura
session_start();
session_regenerate_id(true);

// 🔹 Bloquear acceso si ya hay una sesión de profesor activa
if (isset($_SESSION["profesor_id"])) {
    $_SESSION['mensaje'] = "⚠️ Ya tienes una sesión activa como profesor. Para iniciar sesión como alumno, primero debes cerrar sesión.";
    header("Location: ../../html/login_usuario/login_usuario.html?error=Ya_tienes_sesion_profesor");
    exit();
}

// 🔹 Conexión a la base de datos
require_once('../../php/conexion/conexion.php');

// ✅ Si ya hay una sesión activa, mostramos un mensaje antes de redirigir
if (isset($_SESSION['usuario'])) {
    $_SESSION['mensaje'] = "⚠️ Ya hay una sesión iniciada. Cierra sesión antes de iniciar otra.";
    header("Location: ../../html/login_usuario/login_usuario.html?sesion_activa=1");
    exit();
}

// 🔹 Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ✅ Filtrar y limpiar datos de entrada
    $usuario = filter_var(trim($_POST['usuario']), FILTER_SANITIZE_EMAIL);
    $contrasena = trim($_POST['contrasena']);

    // 🔹 Uso de `prepared statements` para evitar inyecciones SQL
    $query = "SELECT id, nombre, apellidos, correo, contrasena FROM clientes WHERE correo = ?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        die("Error al preparar la consulta: " . $conexion->error);
    }
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($contrasena, $row['contrasena'])) {

            // 🔹 Bloquea que otro usuario inicie sesión si ya hay una cuenta activa en esta sesión
            if (isset($_SESSION['usuario'])) {
                $_SESSION['mensaje'] = "⚠️ No puedes iniciar otra cuenta mientras hay una sesión activa.";
                header("Location: ../../html/login_usuario/login_usuario.html?sesion_activa=1");
                exit();
            }

            // 🔹 Guarda datos del usuario en la sesión
            $_SESSION['usuario'] = [
                'id' => $row['id'],
                'nombre' => $row['nombre'],
                'apellidos' => $row['apellidos'],
                'correo' => $row['correo']
            ];
            $_SESSION['ultimo_acceso'] = time();

            session_regenerate_id(true); // ✅ Seguridad extra contra robo de sesión

            // 🔹 Redirige al área de alumnos
            header("Location: ../../html/area_alumnos/area_alumnos.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "⚠️ Correo o contraseña incorrectos.";
            header("Location: ../../html/login_usuario/login_usuario.html?error=1");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "⚠️ Correo o contraseña incorrectos.";
        header("Location: ../../html/login_usuario/login_usuario.html?error=1");
        exit();
    }

    $stmt->close();
    $conexion->close();
}
?>
