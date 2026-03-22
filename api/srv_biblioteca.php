<?php
header('Content-Type: application/json');
require_once 'db.php';
session_start();

$metodo = $_SERVER['REQUEST_METHOD'];

// Módulo 12: Manejo de errores con Try-Catch
try {
    if ($metodo === 'POST') {
        // Recibir JSON (Módulo 09)
        $input = json_decode(file_get_contents("php://input"), true);
        
        if (empty($input['nombre']) || empty($input['imagen'])) {
            throw new Exception("Datos del juego incompletos.");
        }

        // Módulo 13: Sentencia preparada (Seguridad)
        $stmt = $pdo->prepare("INSERT INTO biblioteca (id_usuario, nombre_juego, imagen_url) VALUES (?, ?, ?)");
        
        // Usamos ID 1 por defecto para pruebas si no hay login, pero GilPG pide sesión
        $usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 1;
        
        $stmt->execute([$usuario_id, $input['nombre'], $input['imagen']]);

        echo json_encode(["status" => "ok", "mensaje" => "¡Excelente! El juego se guardó en tu BD."]);
    } 
    
    if ($metodo === 'GET') {
        $usuario_id = isset($_SESSION['id']) ? $_SESSION['id'] : 1;
        $stmt = $pdo->prepare("SELECT * FROM biblioteca WHERE id_usuario = ?");
        $stmt->execute([$usuario_id]);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($resultados);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["status" => "error", "mensaje" => $e->getMessage()]);
}
?>