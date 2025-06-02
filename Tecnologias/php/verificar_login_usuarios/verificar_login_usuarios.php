<?php
// Inicia la sesión para poder usar variables de sesión
session_start();

// Establece el tipo de contenido de la respuesta como JSON
header('Content-Type: application/json');

// Incluye el archivo de conexión a la base de datos
require_once('../../php/conexion/conexion.php');

// Lee los datos enviados en formato JSON desde el cuerpo de la petición
$input = json_decode(file_get_contents("php://input"), true);

// Sanitiza y obtiene el usuario (correo electrónico) y la contraseña del input
$usuario = filter_var(trim($input['usuario']), FILTER_SANITIZE_EMAIL);
$contrasena = trim($input['contrasena']);

// Inicializa la respuesta por defecto como fallo
$response = ['success' => false];

// Prepara la consulta SQL para buscar el usuario por correo electrónico
$query = "SELECT id, nombre, apellidos, correo, contrasena FROM clientes WHERE correo = ?";
$stmt = $conexion->prepare($query);

// Asocia el parámetro del correo electrónico a la consulta preparada
$stmt->bind_param("s", $usuario);

// Ejecuta la consulta
$stmt->execute();

// Obtiene el resultado de la consulta
$result = $stmt->get_result();

// Verifica si se encontró algún usuario con ese correo
if ($result->num_rows > 0) {
    // Obtiene los datos del usuario encontrado
    $fila = $result->fetch_assoc();

    // Verifica si la contraseña ingresada coincide con la almacenada (hash)
    if (password_verify($contrasena, $fila['contrasena'])) {
        // Si la contraseña es correcta, guarda los datos del usuario en la sesión
        $_SESSION['usuario'] = [
            'id' => $fila['id'],
            'nombre' => $fila['nombre'],
            'apellidos' => $fila['apellidos'],
            'correo' => $fila['correo']
        ];
        // Guarda el tiempo del último acceso
        $_SESSION['ultimo_acceso'] = time();
        // Regenera el ID de sesión por seguridad
        session_regenerate_id(true);
        // Indica que el login fue exitoso
        $response['success'] = true;
    } else {
        // Si la contraseña es incorrecta, indica el error correspondiente
        $response['error'] = 'contrasena';
    }
} else {
    // Si no se encontró el usuario, indica el error correspondiente
    $response['error'] = 'usuario';
}

// Cierra la consulta preparada y la conexión a la base de datos
$stmt->close();
$conexion->close();

// Devuelve la respuesta en formato JSON
echo json_encode($response);
