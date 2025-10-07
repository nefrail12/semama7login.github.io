<?php
// Iniciar la sesión es lo primero que debemos hacer
session_start();

// Si el usuario ya ha iniciado sesión, redirigirlo a la página de bienvenida
if (isset($_SESSION['usuario_id'])) {
    header('Location: bienvenida.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
require 'conexion.php';

$error = null;
$mensaje = null;

// Comprobar si se ha enviado el formulario por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LÓGICA PARA EL REGISTRO ---
    if (isset($_POST['accion']) && $_POST['accion'] == 'registrar') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($nombre) || empty($email) || empty($password)) {
            $error = "Por favor, rellene todos los campos para el registro.";
        } else {
            // Hashear la contraseña por seguridad
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password_hash);
                $stmt->execute();
                $mensaje = "¡Cuenta creada con éxito! Por favor, inicia sesión.";
            } catch (PDOException $e) {
                $error = "El correo electrónico ya está registrado.";
            }
        }
    }

    // --- LÓGICA PARA EL INICIO DE SESIÓN ---
    if (isset($_POST['accion']) && $_POST['accion'] == 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conexion->prepare("SELECT id, nombre, email, password FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si el usuario existe y la contraseña es correcta
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            header("Location: bienvenida.php");
            exit();
        } else {
            $error = "Correo electrónico o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Acceso</title>
</head>
<body>
    <div class="container" id="container">
        <!-- FORMULARIO DE REGISTRO (SIGN UP) -->
        <div class="form-container sign-up">
            <!-- CORRECCIÓN: Se añaden action y method -->
            <form action="index.php" method="POST">
                <h1>Crear Cuenta</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>Usa tu email para registrarte</span>
                <!-- CORRECCIÓN: Se añade el atributo 'name' a cada input -->
                <input type="text" placeholder="Name" name="nombre" required>
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <!-- CORRECCIÓN: Se añade 'name' y 'value' para identificar la acción -->
                <button type="submit" name="accion" value="registrar">Inscribirse</button>
            </form>
        </div>

        <!-- FORMULARIO DE INICIO DE SESIÓN (SIGN IN) -->
        <div class="form-container sign-in">
            <!-- CORRECCIÓN: Se añaden action y method -->
            <form action="index.php" method="POST">
                <h1>Iniciar Sesión</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>Usa tu email y contraseña</span>
                <!-- Sección para mostrar errores o mensajes de éxito -->
                <?php if ($error): ?>
                    <p style="color: red; font-size: 14px;"><?php echo $error; ?></p>
                <?php endif; ?>
                <?php if ($mensaje): ?>
                    <p style="color: green; font-size: 14px;"><?php echo $mensaje; ?></p>
                <?php endif; ?>
                <!-- CORRECCIÓN: Se añade el atributo 'name' a cada input -->
                <input type="email" placeholder="Email" name="email" required>
                <input type="password" placeholder="Password" name="password" required>
                <a href="#">¿Olvidó su contraseña?</a>
                <!-- CORRECCIÓN: Se añade 'name' y 'value' para identificar la acción -->
                <button type="submit" name="accion" value="login">Iniciar Sesion</button>
            </form>
        </div>

        <!-- PANELES DE ANIMACIÓN (Toggle) -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¡Bienvenido de nuevo!</h1>
                    <p>Inicia sesión con tus datos para continuar.</p>
                    <button class="hidden" id="login">Iniciar Sesion</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¡Hola, Amigo!</h1>
                    <p>Regístrate con tus datos para ser parte de nuestra comunidad.</p>
                    <button class="hidden" id="register">Registrarse</button>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

