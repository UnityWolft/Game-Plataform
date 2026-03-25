<?php

function recibeTexto(string $parametro): false|string
{
  return isset($_REQUEST[$parametro])
    ? (string)$_REQUEST[$parametro]
    : false;
}
