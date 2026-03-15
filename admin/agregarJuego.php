<?php

session_start();

if($_SESSION["rol"]!="admin"){

die("No autorizado");

}

include("../templates/header.php");

?>

<h2>Agregar juego</h2>

<form action="../api/apiAgregarJuego.php" method="POST">

<input class="form-control" name="nombre" placeholder="Nombre del juego">

<br>

<input class="form-control" name="imagen" placeholder="URL imagen">

<br>

<button class="btn btn-success">

Agregar

</button>

</form>

<?php include("../templates/footer.php"); ?>