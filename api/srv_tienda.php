<?php
header('Content-Type: application/json');
// Mashup con la API de FreeToGame
$url = "https://www.freetogame.com/api/games?platform=pc";

$response = file_get_contents($url);

if ($response === false) {
    echo json_encode(["error" => "No se pudo conectar con el servicio externo"]);
} else {
    echo $response; // Reenvía el JSON de terceros (Módulo 11)
}