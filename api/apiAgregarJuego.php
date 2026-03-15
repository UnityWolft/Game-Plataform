<?php

include("../config/conexion.php");

$nombre=$_POST["nombre"];
$imagen=$_POST["imagen"];

$sql="INSERT INTO juegos(nombre,imagen)
VALUES('$nombre','$imagen')";

if($conn->query($sql)){

echo "Juego agregado";

}else{

echo "Error";

}

?>