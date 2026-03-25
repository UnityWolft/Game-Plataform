<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/recibeJson.php';
require_once __DIR__ . '/lib/recibeEnteroObligatorio.php';
require_once __DIR__ . '/lib/validaEntidadObligatoria.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/lib/devuelveNoContent.php';
require_once __DIR__ . '/db.php';

session_start();

// Verificamos si hay sesión activa
$usuario_id = $_SESSION['id'] ?? null;
if (!$usuario_id) {
    throw new Exception("Debes iniciar sesión para ver tu biblioteca.");
}

$metodo = $_SERVER['REQUEST_METHOD'];

// CASO GET: Listar los juegos del usuario
if ($metodo === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id_usuario = ? ORDER BY id DESC");
    $stmt->execute([$usuario_id]);
    $juegos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    devuelveJson($juegos);
}

// CASO DELETE: Eliminar un juego específico
if ($metodo === 'DELETE') {
    // Busca el 'id' en la URL (api/srv_biblioteca.php?id=...)
    $id = recibeEnteroObligatorio('id');

    // Verificamos que el juego pertenezca al usuario logueado
    $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id = ? AND id_usuario = ?");
    $stmt->execute([$id, $usuario_id]);
    $juego = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si no existe o no es suyo, lanza error 404
    validaEntidadObligatoria("Juego", $juego);

    // Procedemos a borrar
    $stmt = $pdo->prepare("DELETE FROM biblioteca WHERE id = ?");
    $stmt->execute([$id]);

    // Envía respuesta 204 (Éxito sin contenido)
    devuelveNoContent();
}