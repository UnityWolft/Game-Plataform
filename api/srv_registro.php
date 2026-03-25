<?php
// 1. Cargar el manejador de errores primero (para ver errores en JSON)
require_once __DIR__ . '/lib/manejaErrores.php';

// 2. Cargar la función que te está dando el error
require_once __DIR__ . '/lib/recibeJson.php';

// 3. Cargar el resto de dependencias
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/db.php';

session_start();

try {
    // Aquí es donde ya no fallará porque ya cargamos el archivo arriba
    $data = recibeJson();

    // Validar que vengan los datos (usando la estructura de tu objeto JSON)
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