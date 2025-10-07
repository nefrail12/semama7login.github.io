<?php
$servidor = "localhost";    // Tu servidor de base de datos, generalmente localhost
$usuario_db = "root";       // Tu usuario de base de datos de XAMPP
$password_db = "";          // La contraseña de XAMPP suele estar vacía por defecto
$nombre_db = "login_db"; // El nombre de la base de datos que creamos

try {
    // Crear una nueva conexión PDO (la forma moderna y segura de conectar)
    $conexion = new PDO("mysql:host=$servidor;dbname=$nombre_db", $usuario_db, $password_db);
    
    // Configurar PDO para que nos informe de los errores en caso de que ocurran
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Si la conexión falla, el script se detiene y muestra un mensaje de error.
    // En un sitio real, no mostrarías el error detallado al usuario por seguridad.
    die("ERROR: No se pudo conectar a la base de datos. " . $e->getMessage());
}
?>