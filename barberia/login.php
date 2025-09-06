<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';
if(!$email) $errors[] = 'Email inválido';
if(empty($password)) $errors[] = 'Ingrese contraseña';


if(empty($errors)){
$stmt = $pdo->prepare('SELECT id,password FROM users WHERE email = ?');
$stmt->execute([$email]);
$user = $stmt->fetch();
if($user && password_verify($password, $user['password'])){
$_SESSION['user_id'] = $user['id'];
header('Location: index.php'); exit;
} else {
$errors[] = 'Email o contraseña incorrectos';
}
}
}
require 'templates/header.php';
?>
<h2>Iniciar sesión</h2>
<?php if($errors): ?>
<div class="errors"><?php foreach($errors as $e) echo '<p>'.htmlspecialchars($e).'</p>'; ?></div>
<?php endif; ?>
<form action="" method="post" id="loginForm">
<label>Email: <input type="email" name="email" required></label>
<label>Contraseña: <input type="password" name="password" required></label>
<button type="submit">Entrar</button>
</form>
<?php require 'templates/footer.php'; ?>


