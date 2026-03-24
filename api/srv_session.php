<?php
header('Content-Type: application/json');
session_start();

if (isset($_SESSION['nombre'])) {
    echo json_encode([
        "logeado" => true,
        "nombre" => $_SESSION['nombre'],
        "id" => $_SESSION['id']
    ]);
} else {
    echo json_encode(["logeado" => false]);
}
?>