<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require_once '../conexion/conexion.php'; // Asegúrate de que la ruta sea correcta

// Generar un CSRF token para el formulario
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Recoger los datos del formulario y sanitizarlos
$nombre = isset($_POST['nombre']) ? htmlspecialchars(trim($_POST['nombre'])) : '';
$apellidos = isset($_POST['apellidos']) ? htmlspecialchars(trim($_POST['apellidos'])) : '';
$dni = isset($_POST['dni']) ? strtoupper(htmlspecialchars(trim($_POST['dni']))) : '';
$telefono = isset($_POST['telefono']) ? htmlspecialchars(trim($_POST['telefono'])) : '';
$correo = isset($_POST['correo']) ? filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL) : '';
$contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';
$fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : '';

// Validaciones
$errores = [];

// Validación de nombre (debe tener al menos 1 caracter)
if (empty($nombre)) {
    $errores['nombre'] = "El nombre es obligatorio.";
}

// Validación de apellidos (debe tener al menos 1 caracter)
if (empty($apellidos)) {
    $errores['apellidos'] = "Los apellidos son obligatorios.";
}

// Validación de DNI (formato: 8 dígitos + una letra)
if (!preg_match("/^[0-9]{8}[A-Za-z]{1}$/", $dni)) {
    $errores['dni'] = "El DNI no tiene el formato válido (8 números seguidos de una letra).";
} else {
    // Verificar si el DNI ya está registrado en la base de datos
    $query = "SELECT * FROM clientes WHERE dni = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errores['dni'] = "El DNI ya está registrado.";
    }
}

// Validación de teléfono (debe ser un número de 9 dígitos)
if (!preg_match("/^[0-9]{9}$/", $telefono)) {
    $errores['telefono'] = "El teléfono debe tener 9 dígitos.";
}

// Validación de correo electrónico (debe ser válido)
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores['correo'] = "El correo electrónico no es válido.";
} else {
    // Verificar si el correo ya está registrado en la base de datos
    $query = "SELECT * FROM clientes WHERE correo = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errores['correo'] = "El correo ya está registrado.";
    }
}

// Validación de contraseña (debe tener al menos 8 caracteres)
if (strlen($contrasena) < 8) {
    $errores['contrasena'] = "La contraseña debe tener al menos 8 caracteres.";
}

// Validación de fecha de nacimiento (debe ser válida)
if (empty($fecha_nacimiento)) {
    $errores['fecha_nacimiento'] = "La fecha de nacimiento es obligatoria.";
}

// Si hay errores, mostrarlos en el formulario
if (!empty($errores)) {
    // No hacer nada, los errores se mostrarán dentro del formulario
} else {
    // Si no hay errores, procesar el registro

    // Hashear la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Preparar la consulta SQL de inserción
    $query = "INSERT INTO clientes (nombre, apellidos, dni, telefono, correo, contrasena, fecha_nacimiento) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sssssss", $nombre, $apellidos, $dni, $telefono, $correo, $contrasena_hash, $fecha_nacimiento);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Almacenar el ID del cliente en una cookie (opcional, por ejemplo para mantener la sesión)
        setcookie("cliente_id", $stmt->insert_id, time() + 3600, "/", "", false, true); // Cookie segura, expira en 1 hora

        // Redirigir a la página de agradecimiento
        header("Location: /Proyecto_Integrado_2025/Tecnologias/html/agradecimiento_registro/agradecimiento_registro.html");
        exit();
    } else {
        // Mostrar error si la consulta falla
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>
