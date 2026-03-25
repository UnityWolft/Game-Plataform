<?php
require_once __DIR__ . '/lib/manejaErrores.php';
require_once __DIR__ . '/lib/devuelveJson.php';
require_once __DIR__ . '/lib/INTERNAL_SERVER_ERROR.php';

// URL de la API de juegos gratuitos
$url = "https://www.freetogame.com/api/games?platform=pc";

// Intentamos obtener los datos de la API externa
$response = @file_get_contents($url);

if ($response === false) {
    // Si la API externa no responde, lanzamos una excepción que manejaErrores capturará
    throw new Exception("No se pudo establecer conexión con el catálogo de juegos externo.");
}

// Convertimos el texto de la API a un arreglo de PHP
$datos = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    throw new Exception("El catálogo externo envió datos corruptos.");
}

// Devolvemos los datos usando la librería estándar
devuelveJson($datos);