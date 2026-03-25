<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/recibeJson.php';
require_once __DIR__ . '/lib/recibeEnteroObligatorio.php';
require_once __DIR__ . '/lib/validaEntidadObligatoria.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/lib/devuelveNoContent.php';
require_once __DIR__ . '/db.php';

session_start();

$usuario_id = $_SESSION['id'] ?? null;
if (!$usuario_id) {
    throw new Exception("Debes iniciar sesión para ver tu biblioteca.");
}

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id_usuario = ? ORDER BY id DESC");
    $stmt->execute([$usuario_id]);
    $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    devuelveJson($juegos);
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
