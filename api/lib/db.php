<?php
$host = 'sql208.infinityfree.com';
$dbname = 'if0_41399432_steam_clone';
$user = 'if0_41399432';
$pass = 'ajecY6AH1U';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Esto enviará el error en formato JSON gracias a tus librerías
    throw new Exception("Error de conexión: " . $e->getMessage());
}