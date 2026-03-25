<?php
require_once  __DIR__ . '/lib/manejaErrores.php';

session_start();


$_SESSION = [];
session_destroy();

header("Location: ../index.html");
exit();