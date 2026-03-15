<?php
include("config/conexion.php");
include("templates/header.php");

$sql="SELECT * FROM biblioteca";
$result=$conn->query($sql);

echo "<h2>Mi biblioteca</h2>";

while($row=$result->fetch_assoc()){
    echo "
    <div class='card mb-3 bg-dark text-light p-3'>
    <img src='{$row["imagen"]}' width='200'>
    <h4>{$row["nombre_juego"]}</h4>
    </div>";
}

include("templates/footer.php");
?>