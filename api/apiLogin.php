<?php

session_start();

include("../config/conexion.php");

$data=json_decode(file_get_contents("php://input"),true);

$correo=$data["correo"];
$password=$data["password"];

$sql="SELECT * FROM usuarios WHERE correo='$correo'";

$result=$conn->query($sql);

if($result->num_rows==1){

$user=$result->fetch_assoc();

if(password_verify($password,$user["password"])){

$_SESSION["usuario"]=$user["nombre"];
$_SESSION["id"]=$user["id"];
$_SESSION["rol"]=$user["rol"];

echo json_encode([
"status"=>"ok"
]);

}else{

echo json_encode([
"status"=>"error",
"mensaje"=>"Contraseña incorrecta"
]);

}

}else{

echo json_encode([
"status"=>"error",
"mensaje"=>"Usuario no encontrado"
]);

}

?>