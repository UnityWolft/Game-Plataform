<?php

session_start();

include("../config/conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$id_usuario = $_SESSION["id"];

$nombre = $data["nombre"];
$imagen = $data["imagen"];

// guardar juego
$sql = "INSERT INTO juegos(nombre,imagen)
VALUES('$nombre','$imagen')";

$conn->query($sql);

$idJuego = $conn->insert_id;

// guardar en biblioteca
$sql2 = "INSERT INTO biblioteca(id_usuario,id_juego)
VALUES('$id_usuario','$idJuego')";

if($conn->query($sql2)){

echo json_encode([
"mensaje"=>"Juego agregado a tu biblioteca"
]);

}else{

echo json_encode([
"mensaje"=>"Error al agregar"
]);

}

?>