<?php
// Iniciar la sesión para poder acceder a ella
session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header('Location: index.php');
exit();
?>
