<?php
require_once __DIR__ . "/INTERNAL_SERVER_ERROR.php";
require_once __DIR__ . "/ProblemDetailsException.php";
require_once __DIR__ . "/devuelveResultadoNoJson.php";

/* Hace que se lance una excepción automáticamente
 * cuando se genere un error de PHP.
 */
set_error_handler(function ($severity, $message, $file, $line) {
  throw new ErrorException($message, 0, $severity, $file, $line);
});

/* Manejo de excepciones no atrapadas. */
set_exception_handler(function (Throwable $excepcion) {
  if ($excepcion instanceof ProblemDetailsException) {
    devuelveProblemDetails($excepcion->problemDetails);
  } else {
    devuelveProblemDetails([
      "status" => INTERNAL_SERVER_ERROR,
      "title" => "Error interno del servidor",
      "detail" => $excepcion->getMessage(),
      "type" => "/errors/errorinterno.html"
    ]);
  }
  exit();
});

function devuelveProblemDetails(array $array): void
{
  $json = json_encode($array);

  if ($json === false) {
    devuelveResultadoNoJson();
  } else {
    http_response_code(isset($array["status"]) ? (int)$array["status"] : INTERNAL_SERVER_ERROR);
    header("Content-Type: application/problem+json; charset=utf-8");
    echo $json;
  }
}