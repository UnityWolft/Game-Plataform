<?php

include("config/session.php");
include("config/conexion.php");
include("templates/header.php");
$id = $_SESSION["id"];
$sql = "SELECT juegos.nombre, juegos.imagen
FROM biblioteca
JOIN juegos ON juegos.id = biblioteca.id_juego
WHERE biblioteca.id_usuario = $id";
$result = $conn->query($sql);
echo "<h2>Mi Biblioteca</h2>";
while($row = $result->fetch_assoc()){
echo "
<div class='card bg-dark text-light p-3 mb-3'>
<img src='{$row["imagen"]}' width='200'>
<h4>{$row["nombre"]}</h4>
</div>
";

}
include("templates/footer.php");
?>