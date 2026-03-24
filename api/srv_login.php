<?php
header('Content-Type: application/json');
require_once 'db.php';
require_once 'recibeJson.php';
session_start();

try {
    $input = recibeJson();

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
        echo json_encode(["status" => "error", "mensaje" => "Correo o contraseña incorrectos."]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
}
?>