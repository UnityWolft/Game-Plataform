<?php

header("Content-Type: application/json");

// API de juegos
$url = "https://www.freetogame.com/api/games";

// obtener datos
$response = file_get_contents($url);

// devolver JSON
echo $response;

?>