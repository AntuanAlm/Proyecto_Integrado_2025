<?php
session_start();

echo "<h1>Debug de sesión y cookies</h1>";

echo "<h2>Sesión actual</h2>";
if (!empty($_SESSION)) {
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
} else {
    echo "<p><strong>No hay variables de sesión activas.</strong></p>";
}

echo "<h2>Cookies</h2>";
if (!empty($_COOKIE)) {
    echo "<pre>";
    print_r($_COOKIE);
    echo "</pre>";
} else {
    echo "<p><strong>No hay cookies activas.</strong></p>";
}

echo "<h2>PHP Session ID</h2>";
echo session_id() ? "<p>" . session_id() . "</p>" : "<p>No hay ID de sesión.</p>";

echo "<h2>Cabeceras enviadas</h2>";
if (headers_sent($file, $line)) {
    echo "<p>⚠️ Las cabeceras ya se han enviado en <strong>$file</strong> línea <strong>$line</strong>.</p>";
} else {
    echo "<p>✅ Las cabeceras aún no se han enviado.</p>";
}

// **Verificar sesiones activas en la base de datos**
echo "<h2>Sesiones activas en la base de datos</h2>";

// Ajustamos la ruta del archivo de conexión
$ruta_conexion = __DIR__ . "/../conexion/conexion.php";

if (file_exists($ruta_conexion)) {
    require_once($ruta_conexion);
} else {
    die("⚠️ Error: No se encontró el archivo de conexión en " . $ruta_conexion);
}

try {
    $stmt = $conexion->prepare("SELECT id, nombre, correo FROM clientes WHERE sesion_activa = 1");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p>✅ Se encontraron sesiones activas en la base de datos:</p><ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>ID:</strong> " . $row['id'] . " | <strong>Nombre:</strong> " . $row['nombre'] . " | <strong>Correo:</strong> " . $row['correo'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p><strong>No hay sesiones activas en la base de datos.</strong></p>";
    }
} catch (Exception $e) {
    echo "<p>Error al consultar la base de datos: " . $e->getMessage() . "</p>";
}
?>
