<?php
header('Content-Type: application/json'); // Módulo 09
require_once 'db.php';

// Recibe JSON (Módulo 09)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

try {
    // 1. Validación de datos (Módulo 12)
    if (empty($data['nombre']) || empty($data['correo']) || empty($data['password'])) {
        throw new Exception("Todos los campos son obligatorios.");
    }
    if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("El formato del correo es inválido.");
    }

    // 2. Manejo de Base de Datos (Módulo 13 - Sentencias preparadas)
    $sql = "INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $passHash = password_hash($data['password'], PASSWORD_DEFAULT);
    
    $stmt->execute([$data['nombre'], $data['correo'], $passHash]);

    // 3. Devuelve JSON
    echo json_encode(["status" => "ok", "mensaje" => "Usuario registrado correctamente"]);

} catch (Exception $e) {
    // Manejo de errores (Módulo 12)
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
}