<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
$name = trim($_POST['name'] ?? '');


if(!$email) $errors[] = 'Email inválido';
if(strlen($password) < 6) $errors[] = 'La contraseña debe tener al menos 6 caracteres';


if(empty($errors)){
// Check existing
$stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
$stmt->execute([$email]);
if($stmt->fetch()){
$errors[] = 'El email ya está registrado';
} else {
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO users (email,password,name) VALUES (?,?,?)');
$stmt->execute([$email,$hash,$name]);
$_SESSION['user_id'] = $pdo->lastInsertId();
header('Location: index.php'); exit;
}
}
}
require 'templates/header.php';
?>
<h2>Registrarse</h2>
<?php if($errors): ?>
<div class="errors">
<?php foreach($errors as $e) echo '<p>'.htmlspecialchars($e).'</p>'; ?>
</div>
<?php endif; ?>
<form action="" method="post" id="registerForm">
<label>Nombre: <input type="text" name="name"></label>
<label>Email: <input type="email" name="email" required></label>
<label>Contraseña: <input type="password" name="password" required></label>
<button type="submit">Crear cuenta</button>
</form>
<?php require 'templates/footer.php'; ?>