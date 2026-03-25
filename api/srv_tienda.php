<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/lib/INTERNAL_SERVER_ERROR.php';

$url = "https://www.freetogame.com/api/games?platform=pc";

$response = @file_get_contents($url);

if ($response === false) {
    throw new Exception("No se pudo establecer conexión con el catálogo de juegos externo.");
}

$datos = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception("El catálogo externo envió datos corruptos.");
}

devuelveJson($datos);
