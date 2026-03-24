<?php
$host = 'sql208.infinityfree.com';
$dbname = 'if0_41461498_if0_41461498_ministeam';
$user = 'if0_41461498';
$pass = 'eB0NxSXTGpqbxN';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error" => "Error de conexión: " . $e->getMessage()]));
}
?>