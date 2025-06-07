<?php
header("Content-Type: text/html; charset=UTF-8");

$correo = $_GET['correo'] ?? '';
$tipo_usuario = $_GET['tipo'] ?? '';

if (empty($correo) || empty($tipo_usuario)) {
    echo "<p style='color: red;'>⚠️ Datos inválidos.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer nueva contraseña</title>

    <!-- links de css -->
    <link rel="stylesheet" href="../../css/establecer_contraseña/establecer_contraseña.css">
    <link rel="stylesheet" href="../../css/body_header_nav/body_header_nav.css">
    <link rel="stylesheet" href="../../css/footer_generico/footer.css">


    <!-- Link de las fuentes de google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Boldonse&family=Matemasie&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&family=Winky+Sans:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../img/logo/logo-autoescuela.png" type="image/x-icon">

    <!-- JS -->
    <script src="../../js/enlaces_href/universal.js"></script>
    <script src="../../js/enlaces_src/imagenes.js"></script>
</head>
<body>

<!-- ======================= RECUPERAR CONTRASEÑA Y CAMBIAR ================= -->
 
    <h2>Establecer nueva contraseña</h2>

    <form id="formulario-cambio" method="POST" action="../../php/procesar_cambio_contraseña/procesar_cambio_contraseña.php">
        <input type="hidden" name="correo" value="<?= htmlspecialchars($correo) ?>">
        <input type="hidden" name="tipo_usuario" value="<?= htmlspecialchars($tipo_usuario) ?>">

        <label for="nueva_contrasena">Nueva contraseña:</label>
        <input type="password" name="nueva_contrasena" id="nueva_contrasena" required>
        <p class="mensaje-error" id="error-contrasena"></p>

        <label for="confirmar_contrasena">Confirmar nueva contraseña:</label>
        <input type="password" name="confirmar_contrasena" id="confirmar_contrasena" required>
        <p class="mensaje-error" id="error-confirmar"></p>

        <input type="submit" value="Cambiar contraseña">
        <button type="button" id="mostrar-contrasena" style="margin-top:10px;">Mostrar contraseña</button>
    </form>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const botonAlternar = document.getElementById('mostrar-contrasena');
        const inputContrasena = document.getElementById('nueva_contrasena');
        const inputConfirmar = document.getElementById('confirmar_contrasena');

        if (botonAlternar && inputContrasena && inputConfirmar) {
            botonAlternar.addEventListener('click', function() {
                const mostrar = inputContrasena.type === 'password';
                inputContrasena.type = mostrar ? 'text' : 'password';
                inputConfirmar.type = mostrar ? 'text' : 'password';
                botonAlternar.textContent = mostrar ? 'Ocultar' : 'Mostrar';
            });
        } else {
            console.error("El botón o los campos de contraseña no se encontraron en el DOM.");
        }
    });
    </script>
    <script src="../../js/validacion_recuperacion_contraseña/validacion_recuperacion_contraseña.js" defer></script>
</body>
</html>
