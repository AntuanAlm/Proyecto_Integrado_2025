<?php
session_start();  // Iniciar sesión

// 🔎 Ajustamos la conexión con la base de datos
$ruta_conexion = __DIR__ . "/../conexion/conexion.php";

if (file_exists($ruta_conexion)) {
    require_once($ruta_conexion);
} else {
    die("⚠️ Error: No se encontró el archivo de conexión en " . $ruta_conexion);
}

if (isset($_SESSION['usuario']['email'])) {
    $usuario = mysqli_real_escape_string($conexion, $_SESSION['usuario']['email']);

    // **Cerrar la sesión en la base de datos**
    $query = "UPDATE clientes SET sesion_activa = 0 WHERE correo = '$usuario'";
    if (!mysqli_query($conexion, $query)) {
        die("⚠️ Error al cerrar sesión en la base de datos: " . mysqli_error($conexion));
    } else {
        echo "<p>✅ Sesión cerrada correctamente en la base de datos.</p>";
    }
} else {
    echo "<p>⚠️ No hay un usuario logueado en PHP, pero verificamos en la base de datos...</p>";

    // 🔍 **Buscar usuarios con sesión activa en la base de datos**
    $stmt = $conexion->prepare("SELECT correo FROM clientes WHERE sesion_activa = 1");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuario_db = $row['correo'];
            $query = "UPDATE clientes SET sesion_activa = 0 WHERE correo = '$usuario_db'";
            mysqli_query($conexion, $query);
            echo "<p>✅ Se cerró la sesión para el usuario: $usuario_db</p>";
        }
    } else {
        echo "<p><strong>No hay sesiones activas en la base de datos.</strong></p>";
    }
}

// **Eliminar todas las variables de sesión**
session_unset();
$_SESSION = [];  

// **Eliminar la cookie PHPSESSID**
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/', '', false, true);
}

// **Destruir la sesión**
session_destroy();

// **Regenerar ID de sesión**
session_start();
session_regenerate_id(true);

// **Redirigir a `index.php`**
header("Location: http://localhost/Proyecto_Integrado_2025/Tecnologias/html/Vista_Principal/index.php?cerrado=1");
exit;

?>
