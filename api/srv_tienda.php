<?php
header('Content-Type: application/json');

$url = "https://www.freetogame.com/api/games?platform=pc";

$response = file_get_contents($url);

if ($response === false) {
    echo json_encode(["status" => "error", "mensaje" => "No se pudo conectar con el servicio externo"]);
} else {
    echo $response;
}
?>