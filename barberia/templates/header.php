<?php 
if (session_status() === PHP_SESSION_NONE) session_start();

function isLogged() { 
    return isset($_SESSION['user_id']); 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería</title>
    <!-- Ajusta la ruta de tu CSS -->
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <header class="top">
        <div class="logo">💈 Barbería Estilo</div>
        <nav>
            <a href="index.php">Inicio</a>
            <?php if (isLogged()): ?>
                <a href="my_reservations.php">Mis Reservas</a>
                <a href="logout.php">Cerrar sesión</a>
            <?php else: ?>
                <a href="login.php">Iniciar sesión</a>
                <a href="register.php">Registrarse</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
