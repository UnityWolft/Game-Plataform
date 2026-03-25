<?php
require_once  __DIR__ . '/lib/manejaErrores.php';
require_once  __DIR__ . '/lib/devuelveJson.php';

session_start();

// Verificamos si existe la sesión
if (isset($_SESSION['nombre'])) {
    devuelveJson([
        "logeado" => true,
        "nombre" => $_SESSION['nombre'],
        "id" => $_SESSION['id']
    ]);
} else {
    devuelveJson([
        "logeado" => false
    ]);
}