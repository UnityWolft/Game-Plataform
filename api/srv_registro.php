<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/recibeJson.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/db.php';

session_start();

try {
    $data = recibeJson();
    if (empty($data->nombre) || empty($data->correo) || empty($data->password)) {
        throw new Exception("Todos los campos son obligatorios.");
    }

    $passHash = password_hash($data->password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, correo, password) VALUES (?, ?, ?)");
    $stmt->execute([$data->nombre, $data->correo, $passHash]);

    devuelveJson([
        "status" => "ok",
        "mensaje" => "Usuario registrado correctamente"
    ]);

} catch (PDOException $e) {
    // Si el correo ya existe
    if ($e->errorInfo[1] == 1062) {
        throw new Exception("Ese correo ya está registrado.");
    }
    throw $e;
}
