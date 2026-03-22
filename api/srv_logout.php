<?php
session_start(); // Unirse a la sesión actual
session_unset(); // Limpiar todas las variables de sesión
session_destroy(); // Destruir la sesión por completo

// Redirigir al inicio (puedes mandarlo al login o al index)
header("Location: ../index.html");
exit();
?>