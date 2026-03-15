<?php include("templates/header.php"); ?>
<h2>Registro de usuario</h2>
<form id="formRegistro">
    <input class="form-control" type="text" id="nombre" placeholder="Nombre" required><br>
    <input class="form-control" type="email" id="correo" placeholder="Correo" required><br>
    <input class="form-control" type="password" id="password" placeholder="Contraseña" required><br>
    <button class="btn btn-success">Registrarse</button>
</form>
<script src="js/registro.js"></script>
<?php include("templates/footer.php"); ?>