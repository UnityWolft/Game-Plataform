<?php
session_start();
header('Content-Type: application/json');
require_once 'db.php';

$input = json_decode(file_get_contents("php://input"), true);

try {
    if (empty($input['correo']) || empty($input['password'])) {
        throw new Exception("Datos incompletos.");
    }

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->execute([$input['correo']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($input['password'], $usuario['password'])) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        
        echo json_encode(["status" => "ok", "mensaje" => "Acceso concedido"]);
    } else {
        http_response_code(401);
        throw new Exception("Correo o contraseña incorrectos.");
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
}
