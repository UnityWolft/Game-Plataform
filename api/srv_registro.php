<?php
header('Content-Type: application/json');
require_once 'db.php';
require_once 'recibeJson.php';
session_start();

try {
    $data = recibeJson();

    if (empty($data['nombre']) || empty($data['correo']) || empty($data['password'])) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Formato de correo inválido.");
    }

    $passHash = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
    $stmt->execute([$data['nombre'], $data['correo'], $passHash]);

    echo json_encode(["status" => "ok", "mensaje" => "Usuario registrado correctamente"]);

} catch (PDOException $e) {
    if ($e->errorInfo[1] == 1062) { 
        echo json_encode(["status" => "error", "mensaje" => "El correo ya está registrado."]);
    } else {
        echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
}
?>