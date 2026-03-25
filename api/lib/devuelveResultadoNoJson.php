<?php
require_once __DIR__ . "/INTERNAL_SERVER_ERROR.php";

function devuelveResultadoNoJson(): void
{
  http_response_code(INTERNAL_SERVER_ERROR);
  header("Content-Type: application/problem+json; charset=utf-8");

  echo json_encode([
    "status" => INTERNAL_SERVER_ERROR,
    "title" => "El resultado no puede representarse como JSON.",
    "type" => "/errors/resultadonojson.html"
  ]);

  exit();
}