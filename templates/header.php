<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>

<title>MiniSteam</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-dark text-light">

<nav class="navbar navbar-dark bg-black">

<div class="container">

<a class="navbar-brand" href="/index.php">
🎮 MiniSteam
</a>

<a class="text-light" href="/tienda.php">Tienda</a>

<a class="text-light" href="/biblioteca.php">Biblioteca</a>

<?php if(isset($_SESSION["usuario"])) { ?>

<a class="text-light" href="/logout.php">Salir</a>

<?php } else { ?>

<a class="text-light" href="/login.php">Login</a>

<a class="text-light" href="/registro.php">Registro</a>

<?php } ?>

<?php
if(isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin"){
?>

<a class="text-warning" href="admin/agregarJuego.php">
Panel Admin
</a>

<?php
}
?>

</div>

</nav>

<div class="container mt-4">