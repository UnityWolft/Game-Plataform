<?php
$host="sql208.infinityfree.com";
$user="if0_41399432";
$password="ajecY6AH1U";
$db="if0_41399432_steam_clone";

$conn=new mysqli($host,$user,$password,$db);

if($conn->connect_error){
    die("Error de conexión");
}
?>