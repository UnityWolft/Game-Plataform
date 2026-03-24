<?php
header('Content-Type: application/json');
require_once 'db.php';
session_start();

// Función para recibir JSON
function recibeJson() {
    $input = json_decode(file_get_contents("php://input"), true);
    return $input ?: [];
}

$metodo = $_SERVER['REQUEST_METHOD'];

try {
    $usuario_id = $_SESSION['id'] ?? null;
    if (!$usuario_id) throw new Exception("Debes iniciar sesión para agregar juegos.");

    if ($metodo === 'POST') {
        $input = recibeJson();

        if (empty($input['titulo_juego']) || empty($input['imagen_url'])) {
            throw new Exception("Datos incompletos del juego.");
        }

        $stmt = $pdo->prepare("INSERT INTO biblioteca (id_usuario, titulo_juego, imagen_url, fecha_agregado) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$usuario_id, $input['titulo_juego'], $input['imagen_url']]);

        echo json_encode(["status" => "ok", "mensaje" => "¡Juego agregado a tu biblioteca!"]);
        exit;
    }

    if ($metodo === 'GET') {
        $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id_usuario = ? ORDER BY fecha_agregado DESC");
        $stmt->execute([$usuario_id]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($resultados);
        exit;
    }

    if ($metodo === 'DELETE') {
        $input = recibeJson();
        if (empty($input['id'])) throw new Exception("ID del juego no proporcionado.");

        $stmt = $pdo->prepare("DELETE FROM biblioteca WHERE id = ? AND id_usuario = ?");
        $stmt->execute([$input['id'], $usuario_id]);

        echo json_encode(["status" => "ok", "mensaje" => "Juego eliminado correctamente."]);
        exit;
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
}
?>