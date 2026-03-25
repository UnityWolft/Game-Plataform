<?php

/**
 * Devuelve el texto de un parámetro enviado al
 * servidor por medio de GET, POST o cookie.
 *
 * Si el parámetro no se recibe, devuelve false.
 */
function recibeTexto(string $parametro): false|string
{
  return isset($_REQUEST[$parametro])
    ? (string)$_REQUEST[$parametro]
    : false;
}