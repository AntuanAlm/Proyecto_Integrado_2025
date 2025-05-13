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
?>
