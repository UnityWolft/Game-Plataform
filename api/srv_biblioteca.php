<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/recibeJson.php';
require_once __DIR__ . '/lib/recibeEnteroObligatorio.php'; // Añade esta línea
require_once __DIR__ . '/lib/validaEntidadObligatoria.php'; // Añade esta línea
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/lib/devuelveNoContent.php'; // Añade esta línea
require_once __DIR__ . '/db.php';

session_start();

$usuario_id = $_SESSION['id'] ?? null;
if (!$usuario_id) {
    throw new Exception("Debes iniciar sesión para realizar esta acción.");
}

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id_usuario = ? ORDER BY id DESC");
    $stmt->execute([$usuario_id]);
    devuelveJson($stmt->fetchAll(PDO::FETCH_ASSOC));
}

if ($metodo === 'POST') {
    $input = recibeJson();
    $titulo = $input->titulo ?? '';
    $imagen = $input->imagen ?? '';

    if (empty($titulo)) throw new Exception("Datos incompletos.");

    $stmt = $pdo->prepare("INSERT INTO biblioteca (id_usuario, titulo_juego, imagen_url) VALUES (?, ?, ?)");
    $stmt->execute([$usuario_id, $titulo, $imagen]);

    devuelveJson(["status" => "ok"]);
}

if ($metodo === 'DELETE') {
    $id = recibeEnteroObligatorio('id');
    $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id = ? AND id_usuario = ?");
    $stmt->execute([$id, $usuario_id]);
    $juego = $stmt->fetch(PDO::FETCH_ASSOC);

    validaEntidadObligatoria("Juego", $juego);

    $stmt = $pdo->prepare("DELETE FROM biblioteca WHERE id = ?");
    $stmt->execute([$id]);

    devuelveNoContent();
}
