<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/recibeJson.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/db.php';

session_start();

$input = recibeJson();
$correo = "";
$password = "";

if (is_object($input)) {
    $correo = $input->correo ?? '';
    $password = $input->password ?? '';
} elseif (is_array($input)) {
    $correo = $input['correo'] ?? '';
    $password = $input['password'] ?? '';
}

$correo = trim($correo);
$password = trim($password);

if (empty($correo) || empty($password)) {
    throw new Exception("Faltan credenciales de acceso.");
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['id'] = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];
    
    devuelveJson([
        "status" => "ok", 
        "mensaje" => "Bienvenido a MiniSteam"
    ]);
} else {
    throw new Exception("Correo o contraseña incorrectos.");
}
