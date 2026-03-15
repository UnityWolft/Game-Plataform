<?php
include("../config/conexion.php");

$data=json_decode(file_get_contents("php://input"),true);

$nombre=$data["nombre"];
$correo=$data["correo"];
$password=password_hash($data["password"],PASSWORD_DEFAULT);

if(!$nombre || !$correo){
    echo json_encode(["mensaje"=>"Datos inválidos"]);
    exit;
}

$sql="INSERT INTO usuarios(nombre,correo,password)
VALUES('$nombre','$correo','$password')";

if($conn->query($sql)){
    echo json_encode(["mensaje"=>"Usuario registrado"]);
}else{
    echo json_encode(["mensaje"=>"Error al registrar"]);
}
?>