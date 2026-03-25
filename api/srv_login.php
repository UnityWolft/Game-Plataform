<?php
// 1. Cargar dependencias
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/recibeJson.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/db.php';

// 2. Iniciar sesión
session_start();

// 3. Obtener datos
$input = recibeJson();

// --- CAMBIO IMPORTANTE AQUÍ ---
// Validamos si $input es un objeto o un arreglo para evitar el error de "Faltan credenciales"
$correo = "";
$password = "";

if (is_object($input)) {
    $correo = $input->correo ?? '';
    $password = $input->password ?? '';
} elseif (is_array($input)) {
    $correo = $input['correo'] ?? '';
    $password = $input['password'] ?? '';
}

// Limpiamos espacios en blanco por si acaso
$correo = trim($correo);
$password = trim($password);

if (empty($correo) || empty($password)) {
    // Si entras aquí, es que el JS no está mandando 'correo' o 'password' correctamente
    throw new Exception("Faltan credenciales de acceso.");
}

// 4. Consultar base de datos
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// 5. Verificar contraseña
if ($usuario && password_verify($password, $usuario['password'])) {
    // Guardar datos en la sesión
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];
    
    devuelveJson([
        "status" => "ok", 
        "mensaje" => "Bienvenido a MiniSteam"
    ]);
} else {
    // Si no coincide, lanzamos error
    throw new Exception("Correo o contraseña incorrectos.");
}